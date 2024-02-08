'use client'

import React, { useEffect, useRef, useState } from 'react'
import { useWindowSize } from 'react-use'
import { useHomePageStore } from '@/app/home/Home'
import { ExternalLinks, InternalLinks } from '@/config'
import CtaCardApp from '@/ui/CtaCardApp/CtaCardApp'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import { useIntersectionObserver } from '@/utils/hooks/useIntersectionObserver'
import { useScroll } from '@/utils/hooks/useScroll'
import { findXPercentage } from '@/utils/maths'
import classNames from 'classnames'
//import Banner from '@/app/home/Banner/Banner'
import gsap from 'gsap'

import styles from './Hero.module.scss'

interface HeroProps {
  className?: string
}

export default function Hero({ className }: HeroProps) {

  const [bannerVisible, setBannerVisible] = useState(true);
  const lastScrollY = useRef(0);

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
    lastScrollY.current = window.scrollY;

    const handleScroll = () => {
      const currentScrollY = window.scrollY;
      if (currentScrollY > lastScrollY.current) {
        setBannerVisible(false);
      } else {
        setBannerVisible(true);
      }
      lastScrollY.current = currentScrollY;
    };

    window.addEventListener('scroll', handleScroll);

    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []);

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

          </div>
          <div className={styles.dapps}>
            <T as='h2' size='headline-regular'>
              Dive deep into the next-gen blockchain – Get started with Archethic DApps.
            </T>
            <br />
            <div className={styles.cards}>
              <CtaCardApp
                title='aeBridge'
                description='Discover a seamless transfer of assets'
                button={{ link: ExternalLinks.Bridge, label: '' }}
                variantColor='black'
                env='MAINNET'
              />
              <CtaCardApp
                title='aeWallet'
                description='The first fully decentralized wallet'
                button={{ link: InternalLinks.Wallet, label: '' }}
                variantColor='raspberry'
                env='MAINNET'
              />
              <CtaCardApp
                title='aeExplorer'
                description='Your gateway to transparency and discovery'
                button={{ link: ExternalLinks.aeExpplorer, label: '' }}
                variantColor='black'
                env='MAINNET'
              />
              <CtaCardApp
                title='aeSwap'
                description='Swap assets on-chain, add liquidity & access yield farming'
                button={{ link: ExternalLinks.aeSwapTestnet, label: '' }}
                variantColor='raspberry'
                env='TESTNET'
              />
              <CtaCardApp
                title='aeHosting'
                description='Free your content, forever with decentralized web hosting'
                button={{ link: ExternalLinks.aeHostingTestnet, label: '' }}
                variantColor='black'
                env='TESTNET'
              />
              <CtaCardApp
                title='aePlayground'
                description='Turn your ideas into smart contracts – no expertise required'
                button={{ link: ExternalLinks.aePlaygroundTestnet, label: '' }}
                variantColor='raspberry'
                env='TESTNET'
              />
            </div>
            <br /><br />
          </div>
        </MaxWidthLayoutContainer>
        {/*<span className={styles.mobileBlackBgShape} />*/}

      </section>
      {/*<Banner className={bannerVisible ? 'open' : ''} />*/}

      <span className={styles.heroBlueBgShape} ref={bgColorRef} />
      <div className={styles.bgShapes} ref={shapesRef}>
        <span className={styles.bgShapeA} />
        <span className={styles.bgShapeB} />
        <span className={styles.bgShapeC} />
      </div>
    </>
  )
}
