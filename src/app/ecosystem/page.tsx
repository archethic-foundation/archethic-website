import React from 'react'
import Aeweb from '@/app/ecosystem/Aeweb/Aeweb'
import KeyFeatures2 from '@/app/home/KeyFeatures2/KeyFeatures2'
import Bridge from '@/app/ecosystem/Bridge/Bridge'
import Dex from '@/app/ecosystem/Dex/Dex'
import Wallet from '@/app/ecosystem/Wallet/Wallet'
import Flex from '@/ui/Flex/Flex'
import SectionJoinUs from '@/ui/SectionJoinUs/SectionJoinUs'
import BackgroundShape from '@/ui/Shapes/BackgroundShape/BackgroundShape'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'
import Hero from './Hero/Hero'

import styles from './page.module.scss'

export default function Ecosystem() {
  return (
    <>
      <Hero />
      <KeyFeatures2 />

      <Flex alignItems='center' gap={200} smGap={100} className={styles.topWrapper}>
        <Bridge />
        <Wallet />

        <BackgroundShape
          lightsLayer={<span className={styles.topWrapperLightsLayer} />}
          variant='gradient-light-to-dark-blue'
        />
      </Flex>

      <Flex alignItems='center' gap={100} className={styles.middleWrapper}>
        <Aeweb />
        <Dex />


        <BackgroundShape
          lightsLayer={<span className={styles.middleWrapperLightsLayer} />}
          variant='purple'
          className={styles.backgroundSolidColor}
          style={{
            top: '-150px',
            height: 'calc(100% + 750px)',
          }}
        />
      </Flex>

      <SectionJoinUs />
      <DnaAnimation />
    </>
  )
}
