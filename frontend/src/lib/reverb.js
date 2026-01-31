import ReverbClient from './reverb-client'

const reverb = new ReverbClient({
  url: 'wss://reverb.sig-pt-rizky-badai.com:8443/app/local',
})

// contoh middleware global
reverb.use((payload) => {
  console.log('[Realtime]', payload.channel, payload.event)
  return payload
})

reverb.connect()

export default reverb
