'use client'

import React from 'react'
import { ExternalLinks, InternalLinks } from '@/config'
import CtaCardApp from '@/ui/CtaCardApp/CtaCardApp'
import styles from './DApps.module.scss'
import { T } from '@/ui/Text/Text'
import { Parallax } from '@/ui/Parallax/Parallax'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
interface DAppsProps {
  className?: string
}

export default function DApps({ className }: DAppsProps) {

  return (
    <section id='DApps' className={styles.section}>
      <Parallax speed={1.7}>

        <MaxWidthLayoutContainer className={styles.content}>

          <T as='h2' size='display-large' weight='semibold'>
            <u>Get started</u> with Archethic Services
          </T>
          <div className={styles.cards}>
            <CtaCardApp
              title='aeBridge'
              description='Discover a seamless transfer of assets'
              button={{ link: ExternalLinks.aeBridge, label: '' }}
              variantColor='raspberry'
              env='MAINNET'
            />
            <CtaCardApp
              title='aeWallet'
              description='The first fully decentralized wallet'
              button={{ link: InternalLinks.Wallet, label: '' }}
              variantColor='raspberry'
              env='MAINNET'
            />
            <CtaCardApp
              title='aeExplorer'
              description='Your gateway to transparency and discovery'
              button={{ link: ExternalLinks.aeExplorer, label: '' }}
              variantColor='raspberry'
              env='MAINNET'
            />
            <CtaCardApp
              title='aeSwap'
              description='Swap assets on-chain and access yield farming by adding liquidity'
              button={{ link: ExternalLinks.aeSwap, label: '' }}
              variantColor='raspberry'
              env='MAINNET'
            />
            <CtaCardApp
              title='aeHosting'
              description='Free your content, forever with decentralized web hosting'
              button={{ link: ExternalLinks.aeHostingTestnet, label: '' }}
              variantColor='black'
              env='TESTNET'
            />
            <CtaCardApp
              title='aePlayground'
              description='Turn your ideas into smart contracts – no expertise required'
              button={{ link: ExternalLinks.aePlaygroundTestnet, label: '' }}
              variantColor='black'
              env='TESTNET'
            />

          </div>
        </MaxWidthLayoutContainer >
      </Parallax>
    </section>
  )
}
