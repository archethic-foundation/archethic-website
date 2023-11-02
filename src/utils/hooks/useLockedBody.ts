import { useEffect, useState } from 'react'
import { useIsomorphicLayoutEffect } from '@/utils/hooks/useIsomorphicLayoutEffect'

import styles from '../utils.module.scss'

type ReturnType = [boolean, (locked: boolean) => void]

export function useLockedBody(initialLocked = false): ReturnType {
  const [locked, setLocked] = useState(initialLocked)

  useIsomorphicLayoutEffect(() => {
    if (!locked) {
      return
    }

    const originalPaddingRight = document.body.style.paddingRight
    const scrollbarWidth = window.innerWidth - document.documentElement.offsetWidth

    if (scrollbarWidth) {
      document.body.style.paddingRight = `${scrollbarWidth}px`
    }

    document.documentElement.classList.add(styles.scrollLocked)

    if (document.activeElement) {
      ;(document.activeElement as HTMLElement).blur()
    }

    return () => {
      document.documentElement.classList.remove(styles.scrollLocked)

      if (scrollbarWidth) {
        document.body.style.paddingRight = originalPaddingRight
      }
    }
  }, [locked])

  // Update state if initialValue changes
  useEffect(() => {
    if (locked !== initialLocked) {
      setLocked(initialLocked)
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [initialLocked])

  return [locked, setLocked]
}
