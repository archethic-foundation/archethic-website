'use client'

import React, { ReactNode } from 'react'
import localFont from 'next/font/local'

const PPTelegraf = localFont({
  src: [
    {
      path: '../../../../public/fonts/Telegraf-Light.woff2',
      weight: '300',
      style: 'normal',
    },
    {
      path: '../../../../public/fonts/Telegraf-Regular.woff2',
      weight: '400',
      style: 'normal',
    },
    {
      path: '../../../../public/fonts/Telegraf-Medium.woff2',
      weight: '500',
      style: 'normal',
    },
    {
      path: '../../../../public/fonts/Telegraf-SemiBold.woff2',
      weight: '600',
      style: 'normal',
    },
    {
      path: '../../../../public/fonts/Telegraf-Bold.woff2',
      weight: '700',
      style: 'normal',
    },
  ],
})

export function Body({ children }: { children: ReactNode }) {
  return <body className={PPTelegraf.className}>{children}</body>
}
