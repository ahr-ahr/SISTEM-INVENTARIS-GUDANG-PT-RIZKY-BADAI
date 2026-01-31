import { useEffect } from 'react'
import echo from '../lib/echo'

export default function TestRealtime() {

  useEffect(() => {
    console.log(import.meta.env.VITE_BROADCASTER)
console.log(import.meta.env.VITE_REVERB_APP_KEY)
console.log(import.meta.env.VITE_REVERB_HOST)
console.log(import.meta.env.VITE_REVERB_SCHEME)
  }, [])

  useEffect(() => {
    echo.channel('barang')
      .listen('.BarangMasuk', (e) => {
        console.log('🔥 REALTIME BARANG MASUK:', e)
      })

    return () => {
      echo.leave('barang')
    }
  }, [])

  return (
    <div>
      <h1>Realtime Test</h1>
      <p>Buka console, tunggu event...</p>
    </div>
  )
}
