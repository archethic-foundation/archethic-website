import { useState } from 'react'

import * as styles from '../utils.module.scss'
import {useIsomorphicLayoutEffect} from "./useIsomorphicLayoutEffect.js";



export const useBreakpoints = () => {
  const [isScreenLargeOrUp, setIsScreenLargeOrUp] = useState(false)
  const [isScreenMedium, setIsScreenMedium] = useState(false)
  const [isScreenMediumOrUp, setIsScreenMediumOrUp] = useState(false)
  const [isScreenMediumOrDown, setIsScreenMediumOrDown] = useState(false)
  const [isScreenSmall, setIsScreenSmall] = useState(false)

  useIsomorphicLayoutEffect(() => {
    const mediaLargeUp = window.matchMedia(`(min-width: ${parseInt(styles.gridBreakpoint_lg)}px)`)
    const mediaMediumOnly = window.matchMedia(
        `(min-width: ${parseInt(styles  .gridBreakpoint_md)}px) and (max-width: ${parseInt(styles.gridBreakpoint_lg) - 1
        }px)`
    )
    const mediaMediumUp = window.matchMedia(`(min-width: ${parseInt(styles.gridBreakpoint_md)}px)`)
    const mediaMediumDown = window.matchMedia(
        `(max-width: ${parseInt(styles.gridBreakpoint_lg) - 1}px)`
    )
    const mediaSmallOnly = window.matchMedia(
        `(max-width: ${parseInt(styles.gridBreakpoint_md) - 1}px) `
    )

    const listener = () => {
      setIsScreenLargeOrUp(mediaLargeUp?.matches)
      setIsScreenMedium(mediaMediumOnly?.matches)
      setIsScreenMediumOrUp(mediaMediumUp?.matches)
      setIsScreenSmall(mediaSmallOnly?.matches)
      setIsScreenMediumOrDown(mediaMediumDown.matches)
    }

    listener()
    window.addEventListener('resize', listener)

    return () => window.removeEventListener('resize', listener)
  }, [isScreenLargeOrUp, isScreenMedium, isScreenSmall])

  return {
    isScreenLargeOrUp,
    isScreenMedium,
    isScreenMediumOrUp,
    isScreenSmall,
    isScreenMediumOrDown,
  }
}
