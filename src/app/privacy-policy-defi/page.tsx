'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function PrivacyPolicyDeFi() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Privacy Policy for the Archethic DeFi
          </T>

          <T as='h2' size='headline-medium'>
            Last Updated: TbD
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              In progress
            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div >
  )
}
