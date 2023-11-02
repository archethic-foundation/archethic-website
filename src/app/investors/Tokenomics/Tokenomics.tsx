import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './Tokenomics.module.scss'

export default function Tokenomics() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <Flex gap={40} smGap={24}>
        <Flex gap={24}>
          <T as='h5' size='label-regular'>
            Tokenomics
          </T>
          <T as='h2' size='display-large' weight='semibold' className={styles.title}>
            Token Distribution
            <br />
            <span /> & Economics
          </T>
        </Flex>

        <Flex gap={80} smGap={16} direction='row' smDirection='column' className={styles.text}>
          <T as='p' size='headline-medium'>
            The tokenomics of $UCO outlines the underlying economic principles and design of the
            $UCO token within its ecosystem.
          </T>
          <T size='headline-medium'>
            It encompasses the token{"'"}s supply and distribution dynamics, utility, incentives,
            and overall strategy to ensure its sustainable growth and value proposition.
          </T>
        </Flex>
      </Flex>

      <img
        src='/images/shared/medium-brand-icon-rotated.png'
        srcSet='/images/shared/medium-brand-icon-rotated@2x.png 2x'
        className={styles.floatingImage}
        alt='Brand icon'
      />

      <CircleBlurredShape
        color='gradient-raspberry-purple'
        style={{
          width: '600px',
          index: -1,
          opacity: 0.9,
          left: 'calc(100% - 250px)',
          top: 'calc(50% - 250px)',
          blur: 60,
        }}
      />
    </MaxWidthLayoutContainer>
  )
}
