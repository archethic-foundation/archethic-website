'use client'

import React from 'react'
import RoadmapCard from '@/app/investors/Roadmap/RoadmapCard/RoadmapCard'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './Roadmap.module.scss'

export default function Roadmap() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={24} smGap={16}>
          <T as='h5' size='text-large'>
            Roadmap
          </T>
          <T as='h2' size='display-large' weight='semibold' className={styles.title}>
            Roadmap, milestones <br /> <span />
            <u>& future plans</u> of the project
          </T>
        </Flex>

        <div className={styles.cardsList}>
          <RoadmapCard>
            <T size='text-large'>Q4 2023</T>
            <T as='h4' size='display-extrasmall' weight='bold'>
              Core services
            </T>
            <T as='div' size='headline-medium-small'>
              Ecosytem testing:<br />Native DEX, Bridge, Staking Features, AEWeb
            </T>
            <br />
            <T as='h4' size='display-extrasmall' weight='bold'>
              New Brand<br />Identity
            </T>
            <T as='div' size='headline-medium-small'>
              Redesign of Archethic
            </T>
          </RoadmapCard>
          <RoadmapCard>
            <T size='text-large'>Q1 2024 </T>
            <T as='h4' size='display-extrasmall' weight='bold'>
              Core services
            </T>
            <T as='div' size='headline-medium-small'>
              Ecosytem deployment:<br />Native DEX, Bridge, Staking Features, AEWeb
            </T>
            <br />
            <T as='h4' size='display-extrasmall' weight='bold'>
              Launch of Archethic’s DeFi Ecosystem
            </T>
            <T as='div' size='headline-medium-small'>
              International Community Outreach
            </T>
          </RoadmapCard>
          <RoadmapCard>
            <T size='text-large'>Q2 2024</T>
            <T as='h4' size='display-extrasmall' weight='bold'>
              Ecosystem expansion
            </T>
            <T as='div' size='headline-medium-small'>
              Builders Acquisition:<br />Grants program, builders incentives, dApp Incubator
            </T>
          </RoadmapCard>
          <RoadmapCard hasBackground={true}>
            <T size='text-large'>Q3 2024</T>
            <T as='h4' size='display-extrasmall' weight='bold'>
              Biometrics
            </T>
            <T as='div' size='headline-medium-small'>
              Archethic Biometrics Devices
            </T>
          </RoadmapCard>
        </div>

        <span className={styles.lightsLayer} />
      </MaxWidthLayoutContainer>
    </div>
  )
}
