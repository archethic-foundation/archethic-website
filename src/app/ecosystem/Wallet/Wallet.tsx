import React from 'react'
import { InternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import Flex from '@/ui/Flex/Flex'
import SectionPrimary from '@/ui/SectionPrimary/SectionPrimary'
import { T } from '@/ui/Text/Text'
import { TextLink } from '@/ui/TextLink/TextLink'

import styles from './Wallet.module.scss'

export default function Wallet() {
  return (
    <SectionPrimary backgroundImage='leftConnerBrandIcon' className={styles.container}>
      <Flex direction='column' gap={48} smGap={24}>
        <Flex direction='column' gap={24} smGap={16}>
          <T as='h5' size='label-regular'>
            Wallet
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            Securely store, transfer and swap tokens and collectibles.
          </T>
        </Flex>

        <Flex direction='row' smDirection='column' gap={140} smGap={16} className={styles.content}>
          <T size='headline-medium-small'>
            Introducing the Archethic Wallet on the Mainnet – your secure gateway to the
            decentralized world. Seamlessly store, transfer, and swap tokens and collectibles with
            confidence.
          </T>
          <Flex direction='column' gap={24}>
            <T size='headline-medium-small'>
              {/* eslint-disable-next-line react/no-unescaped-entities */}
              With the Archethic Wallet, you're not just holding tokens; you're holding the keys to
              a new era of financial sovereignty.
            </T>
            <TextLink
              color='raspberry-300'
              label='View details'
              to={InternalLinks.Wallet}
              target='_blank'
              icon={<ArrowRightIcon />}
            />
          </Flex>
        </Flex>
      </Flex>
    </SectionPrimary>
  )
}
