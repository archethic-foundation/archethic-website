'use client'

import React from 'react'
import classNames from 'classnames'
import dynamic from 'next/dynamic'

import styles from './DnaAnimation.module.scss'

const DNAScene = dynamic(() => import('../../../canvas/DNAScene').then((mod) => mod), {
  ssr: false,
})

interface HeroProps {
  className?: string
}

export default function DnaAnimation({ className }: HeroProps) {
  return (
    <div className={classNames(styles.container, className)}>
      <DNAScene />
    </div>
  )
}
