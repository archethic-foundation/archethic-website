import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span>A</span> <span>Peek</span> <span>into</span> <br />
        <i />
        <span>
          <u>innovation</u>
        </span>
      </T>
    </SectionHero>
  )
}
