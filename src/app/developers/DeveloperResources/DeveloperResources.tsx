import React from 'react'
import { ExternalLinks } from '@/config'
import CtaCard from '@/ui/CtaCard/CtaCard'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './DeveloperResources.module.scss'

export default function DeveloperResources() {
  return (
    <MaxWidthLayoutContainer id='developerResources' className={styles.container}>
      <Flex gap={16} alignItems='center' className={styles.content}>
        <T as='h2' size='display-large' weight='semibold'>
          Developer Resources
        </T>
        <T as='p' size='headline-medium' textWrap={false}>
          Access essential developer resources to kickstart your journey with Archethic.
        </T>
      </Flex>
      <div className={styles.cards}>
        <CtaCard
          variantColor='black'
          title='Github'
          description='Explore the power of open source and the transparency of our codebase on GitHub!'
          button={{ link: ExternalLinks.Github, label: 'View repositories', onNewTab: true }}
          image={{
            src: '/images/home/embrace-journey-card-invest-bg.png',
            srcRetina: '/images/home/embrace-journey-card-invest-bg@2x.png',
          }}
        />
        <CtaCard
          variantColor='raspberry'
          title='Documentation'
          description="Discover essential developer documentation for Archethic's platform features and integrations."
          button={{ link: ExternalLinks.Documentation, label: 'View document', onNewTab: true }}
          image={{
            src: '/images/home/embrace-journey-card-building-bg.png',
            srcRetina: '/images/home/embrace-journey-card-building-bg@2x.png',
          }}
        />
      </div>
      <span className={styles.gradientShape} />
    </MaxWidthLayoutContainer>
  )
}
