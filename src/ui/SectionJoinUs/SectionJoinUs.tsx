import React from 'react'
import { SocialNetworks } from '@/config'
import ButtonSocial from '@/ui/ButtonSocial/ButtonSocial'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './SectionJoinUs.module.scss'

interface SectionJoinUsProps {
  className?: string
}

export default function SectionJoinUs({ className }: SectionJoinUsProps) {
  return (
    <MaxWidthLayoutContainer as='section' className={classNames(styles.section, className)}>
      <div className={styles.container}>
        <Flex direction='column' gap={16} smGap={12}>
          <T as='h5' size='label-regular'>
            Join us
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            Join the Community
          </T>
          <T as='p' size='headline-medium' className={styles.descriptionText}>
            Connect, collaborate, and engage with like-minded individuals in the Archethic
            community.
          </T>
        </Flex>

        <div className={styles.buttonsList}>
          {SocialNetworks.map((app, i) => (
            <ButtonSocial app={app} key={i} />
          ))}
        </div>
      </div>
    </MaxWidthLayoutContainer>
  )
}
