import React from 'react'
import SwapListItem from '@/app/ecosystem/Swap/SwapListItem'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './Swap.module.scss'

export default function Swap() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <Flex direction='row' smDirection='column' gap={80} smGap={40}>
        <Flex direction='column' gap={24} className={styles.content}>
          <Flex alignItems="center" direction="row" className={styles.SwapHeader}>
            <T as='h5'>
              aeSwap - MAINNET 🟢
            </T>
          </Flex>
          <T as='h2' size='display-medium' weight='semibold' className={styles.title}>
            <u>SWAP</u> assets on-chain<br />and access yield farming<br />by adding liquidity
          </T>

          <div className={styles.button}>
            <Button
              label='aeSwap'
              variant='primary'
              to={ExternalLinks.aeSwap}
              target='_blank'
              icon={<ArrowRightIcon />}
            />
          </div>
        </Flex>

        <Flex direction='column' gap={32} className={styles.list}>
          <SwapListItem
            iconRotation={135}
            text='Swap assets on our gas-efficient blockchain, for fees as low as 0.5%'
          />
          <SwapListItem
            iconRotation={135}
            text="Earn through yield farming by providing liquidity to pools!"
          />
          <SwapListItem
            iconRotation={135}
            text='Create your own pools and bring your tokens to life!'
          />
        </Flex>
      </Flex>
    </MaxWidthLayoutContainer>
  )
}
