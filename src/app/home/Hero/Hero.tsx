'use client'

import React, { useEffect, useRef } from 'react'
import { useWindowSize } from 'react-use'
import { useHomePageStore } from '@/app/home/Home'
import { ExternalLinks, InternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import { useIntersectionObserver } from '@/utils/hooks/useIntersectionObserver'
import { useScroll } from '@/utils/hooks/useScroll'
import { findXPercentage } from '@/utils/maths'
import classNames from 'classnames'
import gsap from 'gsap'

import styles from './Hero.module.scss'

interface HeroProps {
  className?: string
}

export default function Hero({ className }: HeroProps) {
  const scrollY = useScroll()
  const sections = useHomePageStore((state) => state.sections)
  const wrapperRef = useRef<HTMLDivElement>(null)
  const shapesRef = useRef<HTMLDivElement>(null)
  const bgColorRef = useRef<HTMLDivElement>(null)
  const { height: windowHeight } = useWindowSize()
  const entry = useIntersectionObserver(wrapperRef, {
    freezeOnceVisible: true,
  })
  const inView = !!entry?.isIntersecting
  const titleRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    if (!sections) {
      return
    }

    const sectionStart = 0
    const sectionEnd = sections.hero.height

    const progress = Math.floor(findXPercentage(scrollY, sectionStart, sectionEnd)) / 100
    const opacity = 1 - progress

    gsap.to(shapesRef.current, {
      opacity: Math.max(opacity, 0),
      duration: 0.5,
    })

    gsap.from(bgColorRef.current, {
      opacity: Math.max(opacity, 0),
      duration: 0.8,
    })
  }, [windowHeight, sections, scrollY])

  return (
    <>
      <section id='hero' className={classNames(styles.container, className)} ref={wrapperRef}>
        <MaxWidthLayoutContainer className={styles.content}>
          <T
            as='h1'
            size='display-extralarge'
            className={styles.heroTitle}
            ref={titleRef}
            inView={inView}
          >
            <span><u>Digital</u></span> <span>sovereignty</span> <i /> <span>at</span> <span>your</span>{' '}
            <span>
              fingertips
            </span>
          </T>
          <div className={styles.heroDescription} data-inview={inView}>
            <T as='h2' size='headline-regular'>
              Build decentralized services accessible to billions
            </T>
            <div className={styles.buttonsList}>
              <Button
                label='Archethic Bridge'
                to={ExternalLinks.Bridge}
                target='_blank'
                variant='secondary'
                icon={<ArrowRightIcon />}
              />
              <Button
                label='Archethic Wallet'
                variant='secondary'
                to={InternalLinks.Wallet}
                icon={<ArrowRightIcon />}
              />
            </div>
          </div>
        </MaxWidthLayoutContainer>
        {/*<span className={styles.mobileBlackBgShape} />*/}
      </section>

      <span className={styles.heroBlueBgShape} ref={bgColorRef} />
      <div className={styles.bgShapes} ref={shapesRef}>
        <span className={styles.bgShapeA} />
        <span className={styles.bgShapeB} />
        <span className={styles.bgShapeC} />
      </div>
    </>
  )
}
