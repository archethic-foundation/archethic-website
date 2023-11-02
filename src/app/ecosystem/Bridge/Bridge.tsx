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
          <T as='h5' size='label-regular'>
            Bridge
          </T>
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
              label='Archethic Bridge'
              variant='primary'
              to={ExternalLinks.Bridge}
              target='_blank'
              icon={<ArrowRightIcon />}
            />
          </div>
        </Flex>

        <Flex direction='column' gap={32} className={styles.list}>
          <BridgeListItem
            iconRotation={135}
            text='Our Bridge on the Mainnet provides a secure and efficient portal for depositing and withdrawing assets. '
          />
          <BridgeListItem
            iconRotation={135}
            text="With Archethic's Bridge, you're opening a gateway to broader possibilities within our expanding ecosystem. "
          />
          <BridgeListItem
            iconRotation={135}
            text='Explore the convenience and reliability of our Bridge as we pave the way for your financial interactions on the Mainnet.'
          />
        </Flex>
      </Flex>
    </MaxWidthLayoutContainer>
  )
}
