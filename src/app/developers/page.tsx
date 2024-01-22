'use client'

import React, { useEffect, useRef } from 'react'
import DeveloperResources from '@/app/developers/DeveloperResources/DeveloperResources'
import DiscordDevelopers from '@/app/developers/DiscordDevelopers/DiscordDevelopers'
import Explore from '@/app/developers/Explore/Explore'
import KeyFeatures2 from '@/app/home/KeyFeatures2/KeyFeatures2'
import JoinUs from '@/app/developers/JoinUs/JoinUs'
import {
  DevelopersPageSections,
  DevelopersPageStore,
  useDevelopersPageStore,
} from '@/app/developers/store'
import BackgroundShape from '@/ui/Shapes/BackgroundShape/BackgroundShape'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'
import Hero from './Hero/Hero'

import styles from './page.module.scss'

export default function Developers() {
  const mainRef = useRef<HTMLDivElement>(null)
  const updateSections = useDevelopersPageStore((state) => state.updateSections)

  useEffect(() => {
    function handleResize() {
      const mainElement = document.querySelector('main')

      if (!mainElement) return

      const sectionElements = mainElement.querySelectorAll('section')
      const sectionsData = {} as DevelopersPageStore['sections']

      sectionElements.forEach((section) => {
        sectionsData![section.id as DevelopersPageSections] = {
          offsetTop: section.offsetTop,
          height: section.clientHeight,
        }
      })

      updateSections(sectionsData)
    }
    handleResize()
    window.addEventListener('resize', handleResize)
    return () => window.removeEventListener('resize', handleResize)
  }, [updateSections])

  return (
    <>
      <Hero />
      <KeyFeatures2 />

      <section id='joinUs' className={styles.topWrapper}>
        <JoinUs />

        <CircleBlurredShape
          color='solid-raspberry'
          style={{
            width: '450px',
            index: -1,
            opacity: 0.6,
            left: '8%',
            top: '0%',
            blur: 180,
          }}
          styleSM={{
            display: 'none',
          }}
        />
      </section>

      <section id='developerResources' className={styles.middleWrapper}>
        <DeveloperResources />

        <BackgroundShape
          variant='gradient-light-to-dark-blue'
          style={{
            top: '-100px',
            height: 'calc(100% + 150px)',
          }}
        />
      </section>

      <section id='explore' className={styles.bottomWrapper}>
        <Explore />

        <BackgroundShape
          lightsLayer={<span className={styles.bottomWrapperLightsLayer} />}
          variant='purple'
          style={{
            top: '0',
            height: '100%',
          }}
        />
      </section>

      <DiscordDevelopers />
      <DnaAnimation />
    </>
  )
}
