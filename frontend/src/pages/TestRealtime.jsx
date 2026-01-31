import { useState } from 'react'
import { useReverbChannel } from '../hooks/useReverbChannel'

export default function TestRealtime() {
  const [alerts, setAlerts] = useState([])

  useReverbChannel(
    'inventory.alert',   // 🔥 channel
    'stok.minimum',      // 🔥 event
    (data) => {
      setAlerts(prev => [...prev, data])
    }
  )

  return (
    <div>
      <h2>Realtime Alert – Stok Minimum</h2>

      {alerts.length === 0 && (
        <p>Belum ada alert</p>
      )}

      {alerts.map((a, i) => (
        <pre key={i}>{JSON.stringify(a, null, 2)}</pre>
      ))}
    </div>
  )
}
