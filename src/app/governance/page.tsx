import React from 'react'
import Biometrics from '@/app/governance/Biometrics/Biometrics'
import Careers from '@/app/governance/Careers/Careers'
import Governance from '@/app/governance/Governance/Governance'
import Hero from '@/app/governance/Hero/Hero'
import Flex from '@/ui/Flex/Flex'
import SectionJoinUs from '@/ui/SectionJoinUs/SectionJoinUs'
import BackgroundShape from '@/ui/Shapes/BackgroundShape/BackgroundShape'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'

import styles from './page.module.scss'

export default function About() {
  return (
    <>
      <Hero />
      <div className={styles.topWrapper}>
        <Governance />

        <BackgroundShape
          lightsLayer={<span className={styles.topWrapperLightsLayer} />}
          variant='gradient-light-to-dark-blue'
          style={{
            top: '0',
            height: 'calc(100% + 85px)',
          }}
        />
      </div>

      <Flex gap={160} smGap={100} alignItems='center' className={styles.middleWrapper}>
        <Biometrics />
        <Careers />

        <BackgroundShape
          lightsLayer={<span className={styles.middleWrapperLightsLayer} />}
          variant='purple'
          className={styles.backgroundShape}
          style={{
            top: '0',
            height: 'calc(100% + 250px)',
          }}
        />
      </Flex>

      <SectionJoinUs />
      <DnaAnimation />
    </>
  )
}
