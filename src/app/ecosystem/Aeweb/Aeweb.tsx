import React from 'react'
import CardSmallWithBlueLineBg from '@/ui/CardSmallWithBlueLineBg/CardSmallWithBlueLineBg'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './Aeweb.module.scss'

export default function Aeweb() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <Flex gap={80} smGap={40}>
        <Flex gap={16}>
          <Flex alignItems="center" direction="row" className={styles.aewebHeader}>
            <T as='h5'>
              aeHosting - TESTNET
            </T>
            <img
              src='/images/ecosystem/up.png'
              alt='UP'
              className={styles.aewebImage}
            />
          </Flex>
          <T as='h2' size='display-large' weight='semibold'>
            Decentralized Web Hosting
          </T>
          <T as='h2' size='headline-medium'>
            Free your content, forever
          </T>
        </Flex>

        <div className={styles.list}>
          <CardSmallWithBlueLineBg
            title='Decentralization'
            text='Your website is fully on-chain, sharded & secured around the world'
          />
          <CardSmallWithBlueLineBg
            title='Immutability'
            text='Your data is censorship-resistant. Tamper-proof as your front-end inherit native blockchain security'
          />
          <CardSmallWithBlueLineBg
            title='Governance'
            text='The web hosting is under the sole regulation of the DAO, ensuring decentralized control'
          />
        </div>
      </Flex>
    </MaxWidthLayoutContainer>
  )
}
