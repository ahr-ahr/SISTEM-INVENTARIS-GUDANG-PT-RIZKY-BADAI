import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const echo = new Echo({
  broadcaster: import.meta.env.VITE_BROADCASTER,
  key: import.meta.env.VITE_REVERB_APP_KEY,

  wsHost: 'reverb.sig-pt-rizky-badai.com',

  forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
  encrypted: true,
  enabledTransports: ['wss'],
  disableStats: true,
  cluster: '',
})

export default echo
