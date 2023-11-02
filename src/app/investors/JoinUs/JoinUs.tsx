import React from 'react'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import SectionSecondary from '@/ui/SectionSecondary/SectionSecondary'
import { T } from '@/ui/Text/Text'

import styles from './JoinUs.module.scss'

export default function JoinUs() {
  return (
    <SectionSecondary>
      <Flex gap={40} className={styles.container}>
        <Flex gap={24}>
          <T as='h5' size='label-regular'>
            Join us
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            Invest in the
            <br />
            <u>Future</u>
          </T>
          <T size='headline-medium'>Join a Community of Web3 pioneers</T>
        </Flex>
        <Button
          label='Join us'
          to={ExternalLinks.InvestorsJoinUs}
          onNewTab={true}
          variant='tertiary'
          icon={<ArrowRightIcon />}
        />
      </Flex>
    </SectionSecondary>
  )
}
