'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import Link from 'next/link'
import styles from './page.module.scss'
import { InternalLinks } from '@/config'
import { ArrowLeftRotatedIcon } from '@/ui/_assets/icons/ArrowLeftRotatedIcon'

export default function PrivacyPolicyWallet() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}
        >


          <T as='h2' size='display-large' weight='semibold'>
            <u>CES</u> 2024
          </T>
          <img
            src='/images/ces/ces24_promo.png'
            className={styles.floatingImage}
            alt='CES'
          />
          <T as='h2' size='headline-medium'>
            Join us at the Web3 Tokenization FinTech Village Pavilion #56039.
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <Link href={InternalLinks.WhitePaperNew} target="_blank" className={styles.navDropdown_link}>Find our new <u>White Paper</u>&nbsp;here <ArrowLeftRotatedIcon />
              </Link>
            </T>
          </div>
          <div>
            <T as='div' size='headline-medium-small'>
              <Link href={InternalLinks.ContactUsCES} prefetch={false}>
                Contact us at <u>ce2024@archethic.net</u>&nbsp;<ArrowLeftRotatedIcon />
              </Link>
            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div>
  )
}
