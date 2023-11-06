import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span>
          <u>Invest</u>
        </span>{' '}
        <span>in</span> <span>the</span><br />
        <i /> <span>services</span> <span>of</span><br />
        <span>tomorrow</span>
      </T>
    </SectionHero>
  )
}
