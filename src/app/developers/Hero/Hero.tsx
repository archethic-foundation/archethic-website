'use client'

import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

interface HeroProps {
  id?: string
  className?: string
}
export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge' textWrap={false}>
        <span><u>Craft</u></span> <span>the</span> <span>future</span>
        <br />
        <i /> <span>of</span>{' '}
        <span>
          decentralized
        </span>
        <br /> <span>applications</span>
      </T>
    </SectionHero>
  )
}
