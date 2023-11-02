'use client'

import { PropsWithChildren, useEffect, useRef } from 'react'
import { useWindowSize } from 'react-use'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import { mapRange } from '@/utils/maths'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger';

interface ParallaxProps {
  speed?: number
  id?: string
  position?: 'top' | 'bottom'
  className?: string
}

export function Parallax({
  className,
  children,
  speed = 1,
  id = 'parallax',
  position,
}: PropsWithChildren<ParallaxProps>) {
  const trigger = useRef<HTMLDivElement>(null)
  const target = useRef<HTMLDivElement>(null)
  const { isScreenSmall } = useBreakpoints()
  const { width: windowWidth } = useWindowSize()

  useEffect(() => {
    if (!target.current || isScreenSmall) {
      return
    }

    const y = windowWidth * speed * 0.1

    const setY = gsap.quickSetter(target.current, 'y', 'px')
    const set3D = gsap.quickSetter(target.current, 'force3D')

    gsap.registerPlugin(ScrollTrigger);

    const timeline = gsap.timeline({
      scrollTrigger: {
        id: id,
        trigger: trigger.current,
        scrub: true,
        start: 'top bottom',
        end: 'bottom top',
        onUpdate: (e) => {
          if (position === 'top') {
            setY(e.progress * y)
          } else {
            setY(-mapRange(0, 1, e.progress, -y, y))
          }

          set3D(e.progress > 0 && e.progress < 1)
        },
      },
    })

    return () => {
      timeline.kill()
    }
  }, [id, speed, position, windowWidth, isScreenSmall])

  return (
    <div ref={trigger} id={id}>
      <div ref={target} className={className}>
        {children}
      </div>
    </div>
  )
}
