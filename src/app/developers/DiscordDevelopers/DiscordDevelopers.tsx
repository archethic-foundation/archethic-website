import React from 'react'
import ButtonSocial from '@/ui/ButtonSocial/ButtonSocial'
import Flex from '@/ui/Flex/Flex'
import SectionSecondary from '@/ui/SectionSecondary/SectionSecondary'
import { T } from '@/ui/Text/Text'

import styles from './DiscordDevelopers.module.scss'

export default function DiscordDevelopers() {
  return (
    <SectionSecondary>
      <Flex gap={40} className={styles.joinUs}>
        <Flex gap={24} smGap={8}>
          <T as='h5' size='label-regular'>
            Join us
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            Discord Developers
          </T>
          <T size='headline-medium'>Join a Community of Web3 pioneers</T>
        </Flex>
        <ButtonSocial app='discord' />
      </Flex>
    </SectionSecondary>
  )
}
