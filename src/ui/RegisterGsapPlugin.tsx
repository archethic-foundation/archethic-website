'use client'

import { useIsomorphicLayoutEffect } from '@/utils/hooks/useIsomorphicLayoutEffect'
import { gsap } from 'gsap/dist/gsap'
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger'

export function RegisterGsapPlugin() {
  useIsomorphicLayoutEffect(() => {
    gsap.defaults({ ease: 'none' })
    gsap.registerPlugin(ScrollTrigger)
    ScrollTrigger.defaults({ markers: process.env.NODE_ENV === 'development' })

    // merge rafs
    gsap.ticker.lagSmoothing(0)
    gsap.ticker.remove(gsap.updateRoot)

    // reset scroll position
    window.scrollTo(0, 0)
    window.history.scrollRestoration = 'manual'
  }, [])

  return <></>
}
