import React from 'react'
import CardSmall from '@/ui/CardSmall/CardSmall'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './Governance.module.scss'

export default function Governance() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer className={styles.governanceContainer}>
        <Flex direction='column' gap={32} smGap={24}>
          <Flex direction='column' gap={24} smGap={8}>
            <T as='h5' size='label-regular'>
              Governance
            </T>
            <T
              as='h2'
              size='display-large'
              weight='semibold'
              className={styles.governanceContainer_title}
            >
              Governance &
              <br />
              <span />
              <u>Voting Power</u> Distribution
            </T>
          </Flex>
          <Flex
            direction='row'
            smDirection='column'
            gap={80}
            smGap={16}
            className={styles.governanceContainer_descriptionColumns}
          >
            <T as='p' size='headline-regular' textWrap={false}>
              Archethic DAO identifies all on-chain participants & rewards voting power accordingly
              to their network contributions.
            </T>
          </Flex>
        </Flex>

        <div className={styles.cardsList}>
          <CardSmall
            variant='primary'
            title='Users'
            text='Every human going through the process of creating his decentralized identity through tamper-proof authentification'
          />
          <CardSmall variant='primary' title='Miners' text=' Individuals who maintain the integrity of the network by operating nodes' />
          <CardSmall
            variant='primary'
            title='Applications & Services'
            text='Builders of decentralized applications (DApps) '
          />
          <CardSmall
            variant='primary'
            title='Technical & Ethical Council'
            text='Developers ranked by the significance of their code contributions'
          />
          <CardSmall
            variant='primary'
            title='Blockchain'
            text='Enable testing of comprehensive functionalities and assessing their potential impact prior to network deployment'
          />
          <CardSmall
            variant='primary'
            title='Foundation'
            text='Leading body for community engagement and governance'
          />
          <CardSmall
            variant='primary'
            title='Archethic'
            text='Entity dedicated to the growth & development of the ecosystem'
          />
        </div>
      </MaxWidthLayoutContainer>

      <CircleBlurredShape
        color='gradient-plum'
        style={{
          width: '1300px',
          index: 0,
          opacity: 0.9,
          left: '-550px',
          top: '0%',
          blur: 15,
        }}
      />

      <CircleBlurredShape
        className={styles.rightBlurShape}
        color='solid-raspberry'
        style={{
          width: '330px',
          index: 0,
          opacity: 0.9,
          left: 'calc(100% - 150px)',
          top: '42%',
          blur: 160,
        }}
      />
    </div>
  )
}
