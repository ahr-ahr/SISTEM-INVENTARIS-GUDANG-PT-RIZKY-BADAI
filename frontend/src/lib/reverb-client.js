class ReverbClient {
  constructor({ url, maxReconnectDelay = 15000 }) {
    this.url = url
    this.socket = null

    // Map<channel, Map<event, Set<callback>>>
    this.channels = new Map()

    // middleware stack
    this.middlewares = []

    this.connected = false
    this.reconnectDelay = 1000
    this.maxReconnectDelay = maxReconnectDelay
    this.shouldReconnect = true
  }

  /* =========================
     CONNECTION
  ========================= */
  connect() {
    if (this.socket && this.socket.readyState === WebSocket.OPEN) {
      return
    }

    this.socket = new WebSocket(this.url)

    this.socket.onopen = () => {
      console.log('Reverb connected')
      this.connected = true
      this.reconnectDelay = 1000
    }

    this.socket.onclose = () => {
      console.warn('Reverb disconnected')
      this.connected = false
      this.socket = null

      if (this.shouldReconnect) {
        setTimeout(() => this.connect(), this.reconnectDelay)
        this.reconnectDelay = Math.min(
          this.reconnectDelay * 2,
          this.maxReconnectDelay
        )
      }
    }

    this.socket.onerror = (e) => {
      console.error('Reverb error', e)
    }

    this.socket.onmessage = (msg) => {
      const payload = JSON.parse(msg.data)

      // handshake → subscribe ulang semua channel
      if (payload.event === 'pusher:connection_established') {
        this.subscribeAll()
        return
      }

      // skip event internal
      if (payload.event?.startsWith('pusher:')) return

      this.dispatch(payload)
    }
  }

  disconnect() {
    this.shouldReconnect = false
    this.socket?.close()
  }

  isConnected() {
    return this.connected
  }

  /* =========================
     MIDDLEWARE
  ========================= */
  use(middleware) {
    this.middlewares.push(middleware)
    return this
  }

  runMiddlewares(payload) {
    let current = payload

    for (const middleware of this.middlewares) {
      current = middleware(current)
      if (!current) return null
    }

    return current
  }

  /* =========================
     SUBSCRIBE
  ========================= */
  subscribe(channel, options = {}) {
    if (!this.channels.has(channel)) {
      this.channels.set(channel, new Map())
    }

    if (!this.connected) return

    const payload = {
      event: 'pusher:subscribe',
      data: { channel },
    }

    // private channel auth
    if (options.auth) {
      payload.data.auth = options.auth
    }

    this.socket.send(JSON.stringify(payload))
  }

  subscribeAll() {
    for (const channel of this.channels.keys()) {
      console.log(`📡 subscribing channel: ${channel}`)
      this.socket.send(JSON.stringify({
        event: 'pusher:subscribe',
        data: { channel },
      }))
    }
  }

  /* =========================
     CHANNEL API (Echo-like)
  ========================= */
  channel(name, options = {}) {
    this.subscribe(name, options)

    return {
      listen: (event, callback) => {
        const events = this.channels.get(name) || new Map()
        const listeners = events.get(event) || new Set()

        listeners.add(callback)

        events.set(event, listeners)
        this.channels.set(name, events)
      },

      stopListening: (event, callback) => {
        const events = this.channels.get(name)
        if (!events) return

        const listeners = events.get(event)
        if (!listeners) return

        listeners.delete(callback)
        if (listeners.size === 0) {
          events.delete(event)
        }
      },
    }
  }

  leave(channel) {
    this.channels.delete(channel)
  }

  /* =========================
     DISPATCH EVENT
  ========================= */
  dispatch(payload) {
    const processed = this.runMiddlewares(payload)
    if (!processed) return

    const { channel, event, data } = processed

    const events = this.channels.get(channel)
    if (!events) return

    const listeners = events.get(event)
    if (!listeners) return

    listeners.forEach((cb) => cb(data))
  }
}

export default ReverbClient
