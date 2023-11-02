import React from 'react'
import SectionHero from '@/ui/SectionHero/SectionHero'
import { T } from '@/ui/Text/Text'

export default function Hero() {
  return (
    <SectionHero id='hero'>
      <T as='h1' size='display-extralarge'>
        <span>Archethic <u>Wallet&nbsp;</u></span>
        <span>the</span> <span>first</span> <span>fully&nbsp;</span>
        <br /><span><u>decentralized</u> wallet</span>
      </T>
    </SectionHero>
  )
}
