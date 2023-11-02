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
          <T as='h5' size='label-regular'>
            AEWEB
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            Redefining Web Hosting
          </T>
          <T as='h2' size='headline-medium'>
            Unshackle your online presence with AEWeb
          </T>
        </Flex>

        <div className={styles.list}>
          <CardSmallWithBlueLineBg
            title='Future of web hosting'
            text='Step into the future of web hosting with AEWeb on the TestNet.'
          />
          <CardSmallWithBlueLineBg
            title='Security'
            text='AEWeb provides a secure, censorship-resistant, and community-driven platform for hosting websites and applications.'
          />
          <CardSmallWithBlueLineBg
            title='Decentralization'
            text='Break free from traditional limitations and experience the new era of decentralized web hosting.'
          />
        </div>
      </Flex>
    </MaxWidthLayoutContainer>
  )
}
