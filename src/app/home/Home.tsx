'use client'

import React, { useEffect, useRef } from 'react'
import Blog from '@/app/home/Blog/Blog'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'
import EmbraceJourney from '@/app/home/EmbraceJourney/EmbraceJourney'
import Hero from '@/app/home/Hero/Hero'
import JoinUs from '@/app/home/JoinUs/JoinUs'
import KeyFeatures from '@/app/home/KeyFeatures/KeyFeatures'
import Mission from '@/app/home/Mission/Mission'
import VideoSection from '@/app/home/VideoSection/VideoSection'
import Vision from '@/app/home/Vision/Vision'
import DApps from '@/app/home/DApps/DApps'
import { Main } from '@/app/layout/Main/Main'
import { create } from 'zustand'

import styles from './Home.module.scss'

type Sections = 'hero' | 'mission' | 'keyFeatures' | 'journeySectionsGroup' | 'blogSectionsGroup'

type State = {
  sections?: Record<
    Sections,
    {
      offsetTop: number
      height: number
    }
  >
}

type Action = {
  updateSections: (sections: State['sections']) => void
}

export const useHomePageStore = create<State & Action>((set) => ({
  sections: undefined,
  updateSections: (sections) => set(() => ({ sections: sections })),
}))

export default function Home() {
  const mainRef = useRef<HTMLDivElement>(null)
  const updateSections = useHomePageStore((state) => state.updateSections)

  useEffect(() => {
    const hash = window.location.hash;
    if (hash) {
      setTimeout(() => {
        const id = hash.replace("#", "");
        const element = document.getElementById(id);
        if (element) {
          element.scrollIntoView();
        }
      }, 0);
    }

    function handleResize() {
      if (!mainRef.current) return

      const sectionElements = mainRef.current.querySelectorAll('section')
      const sectionsData = {} as State['sections']

      sectionElements.forEach((section) => {
        sectionsData![section.id as Sections] = {
          offsetTop: section.offsetTop,
          height: section.clientHeight,
        }
      })

      updateSections(sectionsData)
    }

    window.addEventListener('resize', handleResize)
    return () => window.removeEventListener('resize', handleResize)
  }, [updateSections])

  return (
    <Main ref={mainRef}>
      <Hero />
      <DApps />
      <Mission />
      <KeyFeatures />

      <section id='journeySectionsGroup' className={styles.darkPurpleBgWrapper}>
        <EmbraceJourney />
        <VideoSection />
        <Vision />
      </section>

      <section id='blogSectionsGroup' className={styles.lightPurpleBgWrapper}>
        <Blog />
        <JoinUs />
        <span className={styles.gradientShape} />
      </section>

      <DnaAnimation />
    </Main>
  )
}
