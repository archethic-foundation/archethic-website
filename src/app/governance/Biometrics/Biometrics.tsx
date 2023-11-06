import React from 'react'
import { ExternalLinks } from '@/config'
import CardSmall from '@/ui/CardSmall/CardSmall'
import Flex from '@/ui/Flex/Flex'
import SectionPrimary from '@/ui/SectionPrimary/SectionPrimary'
import { T } from '@/ui/Text/Text'

import styles from './Biometrics.module.scss'

export default function Biometrics() {
  return (
    <SectionPrimary
      backgroundImage='leftConnerBrandIcon'
      backgroundColor='purple-dark'
      className={styles.biometricsContainer}
    >
      <Flex direction='column' gap={16}>
        <T as='h5' size='label-regular'>
          Biometrics
        </T>
        <T as='h2' size='display-large' weight='semibold'>
          Enhancing Security with Biometric Identification
        </T>
        <T size='headline-medium' textWrap={false} className={styles.text}>
          The gateway to a new world of services at the tip of your fingers — the ultimate way to
          really prove your identity.
        </T>
      </Flex>
      <div className={styles.cardsList}>
        <CardSmall
          variant='secondary'
          title='Unique'
          text='Biometric device able to generate your private keys automatically from your finger veins network and without any data storage'
        />
        <CardSmall
          variant='secondary'
          title='Patented'
          text='11 international patents on biometrics & blockchain whose ownership will be delegated to the DAO'
          textLink={{
            label: 'View patents',
            to: ExternalLinks.Patents,
            color: 'raspberry-300',
            onNewTab: true,
          }}
        />
        <CardSmall
          variant='secondary'
          title='Decentralized identity'
          text='Store, share & manage all your digital identities through smart contracts through the tip of your finger'
        />
      </div>
    </SectionPrimary>
  )
}
