import { useEffect } from 'react'
import echo from '../lib/echo'

export default function TestRealtime() {
  console.log('TestRealtime component mounted');
  
  useEffect(() => {
    console.log('SUBSCRIBE barang')
    echo.channel('barang')
      .listen('BarangMasuk', (e) => {
        console.log('REALTIME BARANG MASUK:', e)
      })

    return () => {
      echo.leaveChannel('barang')
    }
  }, [])

  return (
    <div>
      <h1>Realtime Test</h1>
      <p>Buka console, tunggu event...</p>
    </div>
  )
}
