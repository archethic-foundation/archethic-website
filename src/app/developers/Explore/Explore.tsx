import React from 'react'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import CardWithGradientBorder from '@/ui/CardWithGradientBorder/CardWithGradientBorder'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { Parallax } from '@/ui/Parallax/Parallax'
import { T } from '@/ui/Text/Text'

import styles from './Explore.module.scss'

export default function Explore() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex className={styles.cards} direction='row' gap={80} smGap={40}>
          <CardWithGradientBorder
            label='SDK'
            title='The Software Development Kit'
            text='Our comprehensive SDK equips you with the tools, resources, and guidelines needed to seamlessly integrate and innovate within our decentralized ecosystem.'
            button={{
              label: 'Learn more',
              link: ExternalLinks.DevelopmentKit,
              onNewTab: true,
            }}
          />
          <CardWithGradientBorder
            label='PLAYGROUND'
            title='Smart-Contract Playground'
            text='Experience hands-on learning with our Smart Contract Playground. Experiment, test, and refine your smart contract skills in a safe and interactive environment.'
            button={{
              label: 'Learn more',
              link: ExternalLinks.Playground,
              onNewTab: true,
            }}
            image='rightTopCorner'
          />
        </Flex>
      </MaxWidthLayoutContainer>

      <Parallax speed={0.8}>
        <Flex gap={32} className={styles.content} alignItems='center' justifyContent={'center'}>
          <Flex gap={24} smGap={16} alignItems='center'>
            <T as='h5' size='label-regular'>
              Explorer
            </T>
            <T as='h2' size='display-large' weight='semibold'>
              Track <u>everything,</u> everywhere, all at once
            </T>
          </Flex>

          <Button
            label='Explore'
            variant='secondary'
            to={ExternalLinks.Explorer}
            target='_blank'
            icon={<ArrowRightIcon />}
          />
        </Flex>
      </Parallax>
    </div>
  )
}
