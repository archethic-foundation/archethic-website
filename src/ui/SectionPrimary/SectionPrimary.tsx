'use client'

import React, { PropsWithChildren } from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { Parallax } from '@/ui/Parallax/Parallax'
import classNames from 'classnames'

import styles from './SectionPrimary.module.scss'

interface SectionPrimaryProps {
  id?: string
  backgroundImage?: 'none' | 'dottedWave' | 'leftConnerBrandIcon'
  backgroundColor?: 'purple' | 'purple-dark'
  className?: string
  parallax?: boolean
  parallaxSpeed?: number
}

export default function SectionPrimary({
  id,
  backgroundImage,
  backgroundColor = 'purple',
  className,
  parallax = true,
  parallaxSpeed,
  children,
}: PropsWithChildren<SectionPrimaryProps>) {
  if (!parallax) {
    return (
      <section id={id} className={classNames(styles.section, className)}>
        <MaxWidthLayoutContainer>
          <div
            className={classNames(styles.container, styles[`backgroundColor-${backgroundColor}`])}
          >
            <div className={styles.content}>{children}</div>
            <div className={styles.gradientLayer} />
            <div
              className={classNames(styles.backgroundImage, styles[`image-${backgroundImage}`])}
            />
          </div>
        </MaxWidthLayoutContainer>
      </section>
    )
  }

  return (
    <section id={id} className={classNames(styles.section, className)}>
      <Parallax speed={parallaxSpeed || 0.5}>
        <MaxWidthLayoutContainer>
          <div
            className={classNames(styles.container, styles[`backgroundColor-${backgroundColor}`])}
          >
            <div className={styles.content}>{children}</div>
            <div className={styles.gradientLayer} />
            <div
              className={classNames(styles.backgroundImage, styles[`image-${backgroundImage}`])}
            />
          </div>
        </MaxWidthLayoutContainer>
      </Parallax>
    </section>
  )
}
