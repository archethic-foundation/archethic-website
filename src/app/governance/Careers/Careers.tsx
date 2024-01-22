import React from 'react'
import { ExternalLinks, InternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import CtaCard from '@/ui/CtaCard/CtaCard'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './Careers.module.scss'

export default function Careers() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={120} smGap={60}>
          <Flex direction='row' smDirection='column' gap={28} smGap={16} className={styles.content}>
            <Flex gap={24} smGap={16}>
              <T as='h5' size='label-regular'>
                Careers
              </T>
              <T as='h2' size='display-large' weight='semibold'>
                Join our team
              </T>
            </Flex>
            <Flex gap={24}>
              <T size='headline-medium'>
                Explore exciting career opportunities at Archethic and become part of our innovative
                and dynamic team. Join us in shaping the future of decentralized technology.
              </T>

              <Button
                to={ExternalLinks.JoinOurTeam}
                onNewTab={true}
                label='Learn more'
                variant='tertiary'
                size='sm'
                icon={<ArrowRightIcon />}
              />
            </Flex>
          </Flex>
          <div className={styles.cards}>
            <CtaCard
              variantColor='black'
              title='Media Kit'
              description='Access official Archethic brand assets and resources in our Media Kit.'
              button={{
                link: InternalLinks.BrandAssets,
                label: 'Download brand assets',
              }}
              image={{
                src: '/images/home/embrace-journey-card-invest-bg.png',
                srcRetina: '/images/home/embrace-journey-card-invest-bg@2x.png',
              }}
            />
            <CtaCard
              variantColor='raspberry'
              title='Stay in touch'
              description='Connect with us for inquiries and collaboration opportunities.'
              button={{ link: InternalLinks.ContactUs, label: 'Contact us' }}
              image={{
                src: '/images/home/embrace-journey-card-building-bg.png',
                srcRetina: '/images/home/embrace-journey-card-building-bg@2x.png',
              }}
            />
          </div>
          <span className={styles.gradientShape} />
          <span className={styles.gradientShape2} />

          <CircleBlurredShape
            color='solid-raspberry'
            style={{
              width: '500px',
              index: 0,
              opacity: 0.35,
              left: 'calc(50% - 250px)',
              top: '20%',
              blur: 180,
            }}
            styleSM={{
              width: '100%',
              left: '-50%',
              top: '20%',
            }}
          />
        </Flex>
      </MaxWidthLayoutContainer>
    </div>
  )
}
