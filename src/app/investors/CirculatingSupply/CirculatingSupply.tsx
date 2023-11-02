import React from 'react'
import { ExternalLinks } from '@/config'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button } from '@/ui/Button/Button'
import CardSmall from '@/ui/CardSmall/CardSmall'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'
import { T } from '@/ui/Text/Text'

import styles from './CirculatingSupply.module.scss'

export default function CirculatingSupply() {
  return (
    <MaxWidthLayoutContainer className={styles.container}>
      <div className={styles.title}>
        <Flex gap={20}>
          <T as='h5' size='headline-large' weight='bold'>
            UCO Circulating Supply
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            <u>1 Billion </u> total
          </T>
        </Flex>

        <div>
          <Button
            to={ExternalLinks.Tokenomics}
            target='_blank'
            label='Check our tokenomics'
            variant='secondary'
            size='sm'
            icon={<ArrowRightIcon />}
          />
        </div>
      </div>

      <div className={styles.cardsList}>
        <CardSmall variant='stats' counter='38.2%' title='Network Funding' />
        <CardSmall variant='stats' counter='23.6%' title='Adoption rewards' />
        <CardSmall variant='stats' counter='14.5%' title='Team & Advisors' />
        <CardSmall variant='stats' counter='9%' title='Staking Rewards' />
        <CardSmall variant='stats' counter='5.57%' title='Exchange Liquidity' />
        <CardSmall variant='stats' counter='3.44%' title='Gamification & Geo incentives' />
        <CardSmall variant='stats' counter='3.34%' title='Dynamic Miners rewards' />
        <CardSmall variant='stats' counter='2.13%' title='Foundation' />
      </div>

      <CircleBlurredShape
        color='solid-raspberry'
        style={{
          width: '600px',
          index: -1,
          opacity: 0.3,
          left: '-350px',
          top: 'calc(100% - 380px)',
          blur: 100,
        }}
      />
    </MaxWidthLayoutContainer>
  )
}
