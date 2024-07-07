"use client";

import React from "react";
import Flex from "@/ui/Flex/Flex";
import { ExternalLinks, InternalLinks } from '@/config'
import CardSmall from '@/ui/CardSmall/CardSmall'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { MaxWidthLayoutContainer } from "@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer";
import { T } from "@/ui/Text/Text";
import { Button } from '@/ui/Button/Button'
import styles from './Download.module.scss'
import CircleBlurredShape from '@/ui/Shapes/CircleBlurredShape/CircleBlurredShape'

export default function Download() {

  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer className={styles.downloadContainer}>
        <Flex direction='column' gap={32} smGap={24}>
          <Flex direction='column' gap={24} smGap={8}>
            <T as='h5'>
              aeWallet - MAINNET
            </T>
            <T
              as='h2'
              size='display-large'
              weight='semibold'
              className={styles.governanceContainer_title}
            >
              Securely store, transfer and swap tokens and collectibles.
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
              The first FULLY decentralized non-custodial hot wallet
              based on the Layer 1 Archethic Blockchain.
              <br />
              No signup or KYC needed, users just control their services and access keychain,
              protected by different secure access methods like PIN Code, Password, YubiKey like devices and Biometrics.
            </T>

            <img
              src='/images/wallet/mobile_bg.png'
              className={styles.floatingImage}
              alt='Wallet'
            />

          </Flex>
        </Flex>

        <div className={styles.cardsList}>
          <CardSmall
            variant='primary'
            title='iOS'
            text='Apple Store'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletIosDL,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />
          <CardSmall
            variant='primary'
            title='MacOS'
            text='Mac Apple Store'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletMacOSDL,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />
          <CardSmall
            variant='primary'
            title='Android'
            text='Google Play'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletAndroidDL,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />
          <CardSmall
            variant='primary'
            title='Windows'
            text='Microsoft Store'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletWindowsDL,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />
          <CardSmall
            variant='primary'
            title='Linux'
            text='Github'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletLinuxDL,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />
          <CardSmall
            variant='primary'
            title='Chrome Extension'
            text='Chrome Web Store'
            textLink={{
              label: 'Download',
              to: ExternalLinks.WalletExtChrome,
              color: 'raspberry-300',
              onNewTab: true,
            }}
          />

        </div>
        <br />
        <br />
        <Flex gap={24} alignItems='center'>
          <Button
            to={ExternalLinks.WalletLastUpdate}
            onNewTab={true}
            label='Watch last update'
            variant='tertiary'
            size='sm'
            icon={<ArrowRightIcon />}
          />

          <Button
            to={InternalLinks.PrivacyPolicyWallet}
            onNewTab={true}
            label='Privacy Policy'
            variant='tertiary'
            size='sm'
            icon={<ArrowRightIcon />}
          />
        </Flex>

      </MaxWidthLayoutContainer>

      <CircleBlurredShape
        color='solid-raspberry'
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
