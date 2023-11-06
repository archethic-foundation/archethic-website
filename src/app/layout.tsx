import type { Metadata } from 'next'

import '@/ui/_styles/globals.scss'

import React, { ReactNode } from 'react'
import { Body } from '@/app/layout/Body/Body'
import { Footer } from '@/app/layout/Footer/Footer'
import { Main } from '@/app/layout/Main/Main'
import { DesktopNavigation } from '@/app/layout/Navigation/Desktop/DesktopNavigation'
import { MobileNavigation } from '@/app/layout/Navigation/Mobile/MobileNavigation'
import Script from 'next/script'
import NextTopLoader from 'nextjs-toploader'

export const metadata: Metadata = {
  title: 'Archethic - Public Blockchain by Uniris',
  description: 'web3.0 Internet of Trust, email and decentralized web, privacy safeguard',
  viewport: 'width=device-width, user-scalable=no, viewport-fit=cover, initial-scale=1',
}

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang='en'>
      <head>
        <link rel='apple-touch-icon' sizes='180x180' href='/favicon/apple-touch-icon.png' />
        <link rel='icon' type='image/png' sizes='32x32' href='/favicon/favicon-32x32.png' />
        <link rel='icon' type='image/png' sizes='16x16' href='/favicon/favicon-16x16.png' />
        <link rel='manifest' href='/favicon/site.webmanifest' />
        <link rel='mask-icon' href='/favicon/safari-pinned-tab.svg' color='#4027a2' />
        <meta name='msapplication-TileColor' content='#da532c' />
        <meta name='theme-color' content='#ffffff' />
        <title>Archethic - Public Blockchain</title>
        <meta name="description" content="Build decentralized services accessible to billions"></meta>
        <Script defer data-domain='archethic.net' src='https://plausible.io/js/plausible.js' />
      </head>
      <Body>
        <NextTopLoader color='#D55CFF' showSpinner={false} />

        <DesktopNavigation />
        <MobileNavigation />

        <Main>{children}</Main>
        <Footer />
      </Body>
    </html>
  )
}
