'use client'

import React from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { Parallax } from '@/ui/Parallax/Parallax'
import { T } from '@/ui/Text/Text'

import styles from './Mission.module.scss'

interface MissionProps {
  className?: string
}

export default function Mission({ className }: MissionProps) {
  return (
    <section id='mission' className={styles.section}>
      <Parallax speed={1.2}>
        <MaxWidthLayoutContainer className={className}>
          <div className={styles.container}>
            <div className={styles.content}>
              <div className={styles.title}>
                <T as='h5' size='label-regular'>
                  THE MISSION
                </T>
                <T as='h2' size='display-large' weight='semibold'>
                  Secure Identity & Smart Contracts
                </T>
              </div>

              <div className={styles.description}>
                <T as='p' size='headline-regular' textWrap={false}>
                  Archethic aims to create a safer, more inclusive, and transparent internet, where trust is embedded through cutting-edge biometric integration offering a new generation of services.
                </T>
                <T as='p' size='headline-regular' textWrap={false}>
                  Creating a fully autonomous decentralized network in the hands of the world population made by the people, for the people.
                </T>
              </div>
            </div>

            <div className={styles.shapeBgColor} />
            <img
              src='/images/shared/section-primary--leftConnerBrandIcon-bg.png'
              srcSet='/images/shared/section-primary--leftConnerBrandIcon-bg@2x.png 2x'
              alt='brand icon background'
              className={styles.imageBg}
            />
          </div>
        </MaxWidthLayoutContainer>
      </Parallax>
    </section>
  )
}
