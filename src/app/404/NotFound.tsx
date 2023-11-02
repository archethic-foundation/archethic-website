'use client'

import React from 'react'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './NotFound.module.scss'

export default function NotFound() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <Flex direction='row' smDirection='column' justifyContent='center' gap={80} smGap={40}>
        <Flex direction='column' gap={16} className={styles.content}>
          <T as='h5' size='label-regular'>
            Not Found
          </T>
          <T as='h2' size='headline-heavy' weight='semibold' className={styles.title}>
            The page you are looking for doesn{`'`}t exist or has been moved.
          </T>

          <div className={styles.button}>
            <Button
              label='Go to Homepage'
              variant='primary'
              to={ExternalLinks.Bridge}
              target='_blank'
              icon={<ArrowRightIcon />}
            />
          </div>
        </Flex>
      </Flex>

      <CircleBlurredShape
        color='gradient-raspberry-purple'
        style={{
          width: '900px',
          index: -1,
          opacity: 0.9,
          left: '-520px',
          top: '-680px',
          blur: 100,
        }}
        styleSM={{
          width: '700px',
          left: '-620px',
        }}
      />
    </MaxWidthLayoutContainer>
  )
}
