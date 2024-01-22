import React from 'react'
import { InternalLinks } from '@/config'
import CtaCard from '@/ui/CtaCard/CtaCard'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './Vision.module.scss'

interface VisionProps {
  className?: string
}

export default function Vision({ className }: VisionProps) {
  return (
    <MaxWidthLayoutContainer className={className}>
      <div className={styles.container}>
        <div className={styles.title}>
          <T as='h2' size='display-large' weight='semibold'>
            Vision & Technology
          </T>
        </div>

        <div className={styles.cards}>
          <CtaCard
            variantColor='black'
            title='White Paper'
            description='Discover the vision'
            button={{ link: InternalLinks.WhitePaperNew, label: 'View document', variant: 'tertiary', onNewTab: true }}
          />
          <CtaCard
            variantColor='black'
            title='Technical Paper'
            description='Explore the technology'
            button={{ link: InternalLinks.TechnicalPaper, label: 'View document', variant: 'tertiary', onNewTab: true }}
          />
        </div>

        <span className={styles.bgShape} />
      </div>
    </MaxWidthLayoutContainer>
  )
}
