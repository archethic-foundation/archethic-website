import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span>
          <u>Embrace</u>
        </span>{' '}
        <span>the</span> <span>future</span> <br />
        <i /> <span>with</span> <span>Archethic</span>
      </T>
    </SectionHero>
  )
}
