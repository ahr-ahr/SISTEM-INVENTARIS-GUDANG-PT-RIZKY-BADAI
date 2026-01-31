import { useEffect, useRef } from 'react'
import reverb from '../lib/reverb'

export function useReverbChannel(
  channel,
  event,
  handler,
  options = {}
) {
  const savedHandler = useRef(handler)

  useEffect(() => {
    savedHandler.current = handler
  }, [handler])

  useEffect(() => {
    const listener = (data) => {
      savedHandler.current?.(data)
    }

    reverb.channel(channel, options).listen(event, listener)

    return () => {
      reverb.channel(channel).stopListening(event, listener)
    }
  }, [channel, event])
}
