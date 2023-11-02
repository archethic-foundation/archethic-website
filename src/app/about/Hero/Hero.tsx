import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span>
          <u>Pioneering</u>
        </span>
        <br /> <span>Decentralized</span> <span>Identity</span>
        <br />
        <i /> <span>&</span> <span>Governance</span>
      </T>
    </SectionHero>
  )
}
