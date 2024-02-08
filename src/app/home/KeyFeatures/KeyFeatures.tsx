'use client'

import React, { useEffect, useRef, useState } from 'react'
import { useWindowSize } from 'react-use'
import { useHomePageStore } from '@/app/home/Home'
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
    const opacity = Math.min(0.90, opacityProgress / 100);

    gsap.to(shapeARef.current, {
      opacity: Math.max(opacity, 0),
      duration: 0.5,
    })

    // Slide Progress
    const progressSectionStart = sections.keyFeatures.offsetTop
    const progressDistanceScrolled = scrollY - progressSectionStart
    const progressPercentage = Math.floor((progressDistanceScrolled / sections.keyFeatures.height) * 100)

    if (progressPercentage >= 75) {
      setCurrentSlide(4)
    } else if (progressPercentage >= 50) {
      setCurrentSlide(3)
    } else if (progressPercentage >= 25) {
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
      .to(card1Ref.current, {
        startAt: { opacity: 1, scale: 1 },
        opacity: 0,
        scale: outScale
      },
        outDelay
      )
      .from(card3Ref.current, {
        y: outY,
      })
      .to(card3Ref.current, {
        y: 0,
      })
      .to(card2Ref.current, {
        opacity: 0,
        scale: outScale
      },
        outDelay
      )
      .from(card4Ref.current, {
        y: outY
      })
      .to(card4Ref.current, {
        y: 0,
      })
      .to(card3Ref.current, {
        opacity: 0,
        scale: outScale },
        outDelay
      )
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
                  <article ref={card1Ref} className={classNames(styles.keyFeaturesContainer, className)}>
                    <T as='h1' size='display-medium' color='raspberry-300' weight='semibold' style={{ whiteSpace: 'pre-line' }}>
                      The Eldorado of Transaction Chain
                    </T>

                    <T as='p' size='headline-regular'>
                      Archethic introduces a new type of Distributed Ledger Technology: <b>The Transaction Chain</b>.<br />Each block is a transaction. Each transaction is a chain.<br />Merging the capacity of <b>millions</b> of blockchain, <b>into one</b>.
                    </T>
                  </article>
                </div>

                <div className={styles.sliderCard}>
                  <article ref={card2Ref} className={classNames(styles.keyFeaturesContainer, className)}>
                    <T as='h1' size='display-medium' color='raspberry-300' weight='semibold' style={{ whiteSpace: 'pre-line' }}>
                      ARCH Consensus
                    </T>

                    <T as='p' size='headline-regular'>
                      Archethic introduces a <b>new consensus</b>, solving the blockchain trilemma.<br />Linear Scalability with <b>50 TPS</b> per node.<br />Fully decentralized through <b>geo-sharding</b> around the globe. Aeronautic grade security with <b>90%</b> Malicious node tolerance
                    </T>
                  </article>
                </div>

                <div className={styles.sliderCard}>
                  <article ref={card3Ref} className={classNames(styles.keyFeaturesContainer, className)}>
                    <T as='h1' size='display-medium' color='raspberry-300' weight='semibold' style={{ whiteSpace: 'pre-line' }}>
                      New Generation of Services
                    </T>

                    <T as='p' size='headline-regular'>
                      Archethic introduces groundbreaking<br />smart-contract <b>features</b> enabling developers<br />to create a new generation of <b>decentralized applications</b>
                    </T>
                  </article>
                </div>

                <div className={styles.sliderCard}>
                  <article ref={card4Ref} className={classNames(styles.keyFeaturesContainer, className)}>
                    <T as='h1' size='display-medium' color='raspberry-300' weight='semibold' style={{ whiteSpace: 'pre-line' }}>
                      Native Biometric Integration
                    </T>

                    <T as='p' size='headline-regular'>
                      Archethic introduces a tamper-proof biometric identification system that uniquely recognizes individuals <b>without storing</b> any biometric data.<br />Granting seamless access to on-chain services for <b>every human on the planet</b>
                    </T>
                  </article>
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
