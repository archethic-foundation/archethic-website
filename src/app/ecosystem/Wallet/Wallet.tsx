import React from 'react'
import { InternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import Flex from '@/ui/Flex/Flex'
import SectionPrimary from '@/ui/SectionPrimary/SectionPrimary'
import { T } from '@/ui/Text/Text'
import { Button } from '@/ui/Button/Button'
import styles from './Wallet.module.scss'

export default function Wallet() {
  return (
    <SectionPrimary backgroundImage='leftConnerBrandIcon' className={styles.container}>
      <Flex direction='column' gap={48} smGap={24}>
        <Flex direction='column' gap={24} smGap={16}>
          <Flex alignItems="center" direction="row" className={styles.walletHeader}>
            <T as='h5'>
              aeWallet - MAINNET
            </T>
            <img
              src='/images/ecosystem/up.png'
              alt='UP'
              className={styles.walletImage}
            />
          </Flex>
          <T as='h2' size='display-large' weight='semibold'>
            Securely store, transfer and swap tokens and collectibles
          </T>
        </Flex>

        <Flex direction='row' smDirection='column' gap={140} smGap={16} className={styles.content}>
          <T size='headline-medium-small'>
            Welcome to your decentralized home - where creating tokens & NFTs is simple, and managing access to your digital identity is made possible, all without a single line of code.
          </T>

        </Flex>
        <div className={styles.button}>
          <Button
            label='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aeWallet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            variant='primary'
            to={InternalLinks.Wallet}
            target='_blank'
            icon={<ArrowRightIcon />}
          />
        </div>
      </Flex>
    </SectionPrimary>
  )
}
