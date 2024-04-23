import React from 'react'
import BridgeListItem from '@/app/ecosystem/Bridge/BridgeListItem'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './Bridge.module.scss'

export default function Bridge() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <Flex direction='row' smDirection='column' gap={80} smGap={40}>
        <Flex direction='column' gap={24} className={styles.content}>
          <Flex alignItems="center" direction="row" className={styles.bridgeHeader}>
            <T as='h5'>
              aeBridge - MAINNET 🟢
            </T>
          </Flex>
          <T as='h2' size='display-large' weight='semibold' className={styles.title}>
            Discover a{' '}
            <u>
              seamless <br />
              <span />
              transfer
            </u>{' '}
            of assets
          </T>

          <div className={styles.button}>
            <Button
              label='aeBridge'
              variant='primary'
              to={ExternalLinks.aeBridge}
              target='_blank'
              icon={<ArrowRightIcon />}
            />
          </div>
        </Flex>

        <Flex direction='column' gap={32} className={styles.list}>
          <BridgeListItem
            iconRotation={135}
            text='The bridge provides a fully decentralized portal for depositing and withdrawing your assets'
          />
          <BridgeListItem
            iconRotation={135}
            text="The Safety Module safeguards user assets by limiting funds exposure"
          />
          <BridgeListItem
            iconRotation={135}
            text='Atomic Swap guarantees no loss of funds for users through Refund Function'
          />
        </Flex>
      </Flex>
    </MaxWidthLayoutContainer>
  )
}
