import React, { ReactNode } from 'react'
import classNames from 'classnames'

import styles from './BackgroundShape.module.scss'

interface BackgroundShapeProps {
  variant?: 'gradient-light-to-dark-blue' | 'gradient-dark-to-light-blue' | 'purple' | 'dark-purple'
  style?: {
    top?: string
    height?: string
  }
  smStyle?: {
    top?: string
    height?: string
  }
  lightsLayer?: ReactNode
  className?: string
}

export default function BackgroundShape({
  variant,
  style,
  lightsLayer,
  className,
}: BackgroundShapeProps) {
  return (
    <>
      <div
        className={classNames(styles.container, styles[`variant-${variant}`], className)}
        style={{
          top: style?.top || '0',
          height: style?.height || '100%',
        }}
      >
        {lightsLayer}
      </div>
    </>
  )
}
