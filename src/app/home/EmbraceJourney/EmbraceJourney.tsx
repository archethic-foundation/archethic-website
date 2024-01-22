import React from 'react'
import { InternalLinks } from '@/config'
import CtaCard from '@/ui/CtaCard/CtaCard'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './EmbraceJourney.module.scss'

interface EmbraceJourneyProps {
  className?: string
}

export default function EmbraceJourney({ className }: EmbraceJourneyProps) {
  return (
    <MaxWidthLayoutContainer className={className}>
      <div className={styles.container}>
        <div className={styles.title}>
          <T as='h2' size='display-large' weight='semibold'>
            Embrace the Journey
          </T>
        </div>

        <div className={styles.cards}>
          <CtaCard
            variantColor='raspberry'
            title='Become a developer'
            description='Join our developer community and craft the future of decentralized applications.'
            button={{ link: InternalLinks.Developers, label: 'Start building' }}
            image={{
              src: '/images/home/embrace-journey-card-building-bg.png',
              srcRetina: '/images/home/embrace-journey-card-building-bg@2x.png',
            }}
          />
          <CtaCard
            variantColor='black'
            title='Become an investor'
            description='Join us as an investor and profit from the value created within our ecosystem.'
            button={{ link: InternalLinks.Investors, label: 'Get started' }}
            image={{
              src: '/images/home/embrace-journey-card-invest-bg.png',
              srcRetina: '/images/home/embrace-journey-card-invest-bg@2x.png',
            }}
          />
        </div>
        <span className={styles.gradientShape} />
        <span className={styles.gradientShape2} />
      </div>
    </MaxWidthLayoutContainer>
  )
}
