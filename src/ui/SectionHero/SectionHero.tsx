'use client'

import React, { PropsWithChildren, useEffect, useRef } from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { useIntersectionObserver } from '@/utils/hooks/useIntersectionObserver'
import classNames from 'classnames'
import gsap from 'gsap'

import styles from './SectionHero.module.scss'

interface SectionHeroProps {
  className?: string
  id?: string
}

export default function SectionHero({
  id,
  className,
  children,
}: PropsWithChildren<SectionHeroProps>) {
  const imageRef = useRef<HTMLImageElement>(null)
  const sectionRef = useRef<HTMLHeadingElement>(null)
  const entry = useIntersectionObserver(sectionRef || null, {
    freezeOnceVisible: true,
  })
  const inView = !!entry?.isIntersecting

  const handleImageOnLoad = () => {
    if (imageRef.current) {
      gsap.to(imageRef.current, {
        duration: 2,
        opacity: 1,
      })
    }
  }

  useEffect(() => {
    const currentImageRef = imageRef.current

    if (currentImageRef) {
      if (currentImageRef.complete) {
        handleImageOnLoad()
      } else {
        currentImageRef.addEventListener('load', handleImageOnLoad)
      }

      return () => {
        currentImageRef.removeEventListener('load', handleImageOnLoad)
      }
    }
  }, [])

  return (
    <section ref={sectionRef} id={id} className={classNames(styles.container, className)}>
      <div className={styles.section}>
        <MaxWidthLayoutContainer className={styles.content} inView={inView}>
          {children}
        </MaxWidthLayoutContainer>
      </div>

      <span className={styles.lightsLayer} />
      <span className={styles.bottomBlackGradientShape} />
    </section>
  )
}
