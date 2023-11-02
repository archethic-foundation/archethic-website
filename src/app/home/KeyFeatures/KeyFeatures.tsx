'use client'

import React, { useEffect, useRef, useState } from 'react'
import { useWindowSize } from 'react-use'
import { useHomePageStore } from '@/app/home/Home'
import { KeyFeaturesCard } from '@/app/home/KeyFeatures/KeyFeaturesCard/KeyFeaturesCard'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import { useIsomorphicLayoutEffect } from '@/utils/hooks/useIsomorphicLayoutEffect'
import { useScroll } from '@/utils/hooks/useScroll'
import { findXPercentage } from '@/utils/maths'
import classNames from 'classnames'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger'

import styles from './KeyFeatures.module.scss'

interface KeyFeaturesProps {
  className?: string
}

export default function KeyFeatures({ className }: KeyFeaturesProps) {
  const sections = useHomePageStore((state) => state.sections)
  const scrollY = useScroll()

  const { height: windowHeight } = useWindowSize()
  const shapeARef = useRef<HTMLDivElement>(null)
  const [currentSlide, setCurrentSlide] = useState(1)

  const containerRef = useRef<HTMLDivElement>(null)

  const card1Ref = useRef<HTMLDivElement>(null)
  const card2Ref = useRef<HTMLDivElement>(null)
  const card3Ref = useRef<HTMLDivElement>(null)
  const card4Ref = useRef<HTMLDivElement>(null)

  useEffect(() => {
    if (!sections) {
      return
    }

    // Opacity
    const opacitySectionStart = sections.keyFeatures.offsetTop - windowHeight
    const opacitySectionEnd = sections.keyFeatures.offsetTop
    const opacityProgress = Math.floor(
      findXPercentage(scrollY, opacitySectionStart, opacitySectionEnd)
    )
    const opacity = opacityProgress / 100

    gsap.to(shapeARef.current, {
      opacity: Math.max(opacity, 0),
      duration: 0.5,
    })

    // Slide Progress
    const progressSectionStart = sections.keyFeatures.offsetTop
    const progressSectionEnd = sections.keyFeatures.height
    const progressProgress = Math.floor(
      findXPercentage(scrollY, progressSectionStart, progressSectionEnd)
    )

    if (progressProgress > 87) {
      setCurrentSlide(4)
    } else if (progressProgress > 48) {
      setCurrentSlide(3)
    } else if (progressProgress > 10) {
      setCurrentSlide(2)
    } else {
      setCurrentSlide(1)
    }
  }, [scrollY, windowHeight, sections])

  useEffect(() => {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: containerRef.current,
        start: '0% top',
        end: '100% bottom',
        scrub: true,
      },
    })

    const outDelay = '-=0.8'
    const outScale = 0.8
    const outY = '80vh'

    tl.from(card2Ref.current, { y: outY })
      .to(card2Ref.current, {
        y: 0,
      })
      .to(
        card1Ref.current,
        { startAt: { opacity: 1, scale: 1 }, opacity: 0, scale: outScale },
        outDelay
      )
      .from(card3Ref.current, { y: outY })
      .to(card3Ref.current, {
        y: 0,
      })
      .to(card2Ref.current, { opacity: 0, scale: outScale }, outDelay)
      .from(card4Ref.current, { y: outY })
      .to(card4Ref.current, {
        y: 0,
      })
      .to(card3Ref.current, { opacity: 0, scale: outScale }, outDelay)
  }, [])

  useIsomorphicLayoutEffect(() => {
    gsap.registerPlugin(ScrollTrigger)
  }, [])

  return (
    <>
      <section id='keyFeatures' className={styles.sectionWrapper} ref={containerRef}>
        <MaxWidthLayoutContainer className={classNames(styles.section, className)}>
          <div className={styles.container}>
            <div className={styles.title}>
              <T as='h5' size='label-regular'>
                The Key Features
              </T>
              <T as='h2' size='display-large' weight='semibold'>
                Why Archethic
              </T>
            </div>

            <div className={styles.cards}>
              <div className={styles.cardsIndex}>
                <T as='span' size='headline-medium' className={styles.cardsIndexNumber}>
                  {String(currentSlide).padStart(2, '0')}
                </T>
              </div>
              <div className={styles.sliderContainer}>
                <div className={styles.sliderCard}>
                  <KeyFeaturesCard
                    ref={card1Ref}
                    title='The eldorado of transaction chain'
                    description='Each block is a transaction. Each transaction is a chain. Merging the capacity of millions of blockchains, into one.'
                  />
                </div>

                <div className={styles.sliderCard}>
                  <KeyFeaturesCard
                    ref={card2Ref}
                    title='ARCH Consensus'
                    description='Archethic introduces a new consensus, solving the blockchain trilemma. Linear Scalability with 50 TPS per node. Fully decentralized through geo-sharding around the globe. Aeronautic grade security with 90% Malicious node tolerance.'
                  />
                </div>

                <div className={styles.sliderCard}>
                  <KeyFeaturesCard
                    ref={card3Ref}
                    title='New Generation of Services'
                    description='Archethic introduces groundbreaking smart-contract features enabling developers to create a new generation of decentralized applications.'
                  />
                </div>

                <div className={styles.sliderCard}>
                  <KeyFeaturesCard
                    ref={card4Ref}
                    title='Native Biometric Integration'
                    description='Archethic introduces a tamper-proof biometric identification system that uniquely recognizes individuals without storing any biometric data. Granting seamless access to on-chain services for every human on the planet.'
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Backgrounds */}
        </MaxWidthLayoutContainer>
      </section>
      <span className={styles.bgShapeA} ref={shapeARef} />
    </>
  )
}
