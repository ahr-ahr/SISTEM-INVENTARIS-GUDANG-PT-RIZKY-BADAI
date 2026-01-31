import { useState } from 'react'
import { useReverbChannel } from '../hooks/useReverbChannel'

export default function TestRealtime() {
  const [messages, setMessages] = useState([])

  useReverbChannel(
    'barang',
    'BarangMasuk',
    (data) => {
      setMessages(prev => [...prev, data])
    }
  )

  return (
    <div>
      <h2>Realtime (Production)</h2>

      {messages.map((m, i) => (
        <pre key={i}>{JSON.stringify(m, null, 2)}</pre>
      ))}
    </div>
  )
}
