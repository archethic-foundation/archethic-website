'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { Parallax } from '@/ui/Parallax/Parallax'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './Dex.module.scss'

export default function Dex() {
  return (
    <div className={styles.container}>
      <Parallax speed={0}>
        <MaxWidthLayoutContainer>
          <Flex gap={24} smGap={16} alignItems='center' className={styles.dexContainer}>
            <T as='h5'>
              aeSwap
            </T>
            <T as='h2' size='display-large' weight='semibold'>
              SWAP assets on-chain, add liquidity & access yield farming.
            </T>
            <T as='h5' size='label-regular'>
              Soon
            </T>
          </Flex>
        </MaxWidthLayoutContainer>
      </Parallax>

      <CircleBlurredShape
        className={styles.circleBlurredShape1}
        color='solid-raspberry'
        style={{
          width: '500px',
          index: 0,
          opacity: 0.35,
          left: '-300px',
          top: '-15%',
          blur: 150,
        }}
      />

      <CircleBlurredShape
        className={styles.circleBlurredShape2}
        color='gradient-raspberry-purple'
        style={{
          width: '700px',
          index: 0,
          opacity: 0.7,
          left: 'calc(100% - 400px)',
          top: '-20%',
          blur: 0,
        }}
      />
    </div>
  )
}
