import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const echo = new Echo({
  broadcaster: 'reverb',
  key: 'local',

  wsHost: 'reverb.sig-pt-rizky-badai.com',

  forceTLS: true,

  enabledTransports: ['wss'],
})

echo.connector.pusher.connection.bind('connected', () => {
  console.log('✅ REVERB CONNECTED')
})

echo.connector.pusher.connection.bind('error', (err) => {
  console.error('❌ REVERB ERROR', err)
})

export default echo
