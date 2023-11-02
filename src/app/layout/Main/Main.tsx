'use client'

import React, { forwardRef, ReactNode, useEffect } from 'react'
import { useIsomorphicLayoutEffect } from '@/utils/hooks/useIsomorphicLayoutEffect'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger'
import { usePathname } from 'next/navigation'

interface MainProps {
  children: ReactNode
}

export const Main = forwardRef<HTMLElement, MainProps>(({ children }, ref) => {
  const pathname = usePathname()

  useEffect(() => {
    gsap.defaults({ ease: 'none' })
    gsap.registerPlugin(ScrollTrigger)
    ScrollTrigger.defaults({ markers: process.env.NODE_ENV === 'development' })

    window.scrollTo(0, 0)
    window.history.scrollRestoration = 'manual'
  }, [])

  useIsomorphicLayoutEffect(() => {
    ScrollTrigger.refresh()
    window.scrollTo(0, 0)
  }, [pathname])

  return (
    <>
      <main ref={ref}>{children}</main>
    </>
  )
})
