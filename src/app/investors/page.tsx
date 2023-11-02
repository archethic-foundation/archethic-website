import React from 'react'
import CirculatingSupply from '@/app/investors/CirculatingSupply/CirculatingSupply'
import Hero from '@/app/investors/Hero/Hero'
import JoinUs from '@/app/investors/JoinUs/JoinUs'
import Overview from '@/app/investors/Overview/Overview'
import Roadmap from '@/app/investors/Roadmap/Roadmap'
import Team from '@/app/investors/Team/Team'
import Tokenomics from '@/app/investors/Tokenomics/Tokenomics'
import Flex from '@/ui/Flex/Flex'
import BackgroundShape from '@/ui/Shapes/BackgroundShape/BackgroundShape'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'
import styles from './page.module.scss'

export default function Investors() {
  return (
    <>
      <Hero />
      <Flex alignItems='center' gap={180} smGap={100} className={styles.topWrapper}>
        <Overview />
        <Tokenomics />
        <CirculatingSupply />

        <BackgroundShape
          lightsLayer={<span className={styles.topWrapperLightsLayer} />}
          variant='purple'
          style={{
            top: '250px',
            height: 'calc(100% - 250px)',
          }}
        />
      </Flex>

      <div className={styles.middleWrapper}>
        <Team />

        <BackgroundShape
          variant='dark-purple'
          style={{
            top: '0',
            height: '100%',
          }}
        />
      </div>

      <div className={styles.bottomWrapper}>
        <Roadmap />

        <BackgroundShape
          variant='gradient-dark-to-light-blue'
          style={{
            top: '0',
            height: 'calc(100% + 180px)',
          }}
        />
      </div>

      <JoinUs />
      <DnaAnimation />
    </>
  )
}
