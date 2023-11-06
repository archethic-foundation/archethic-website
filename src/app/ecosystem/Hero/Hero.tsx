import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span><u>Accelerate</u></span>
        <br />
        <i /><span>adoption</span> <span>with</span>{' '}
        <br /><span>native</span> <span>services</span>

      </T>
    </SectionHero>
  )
}
