import React, { CSSProperties } from 'react'
import classNames from 'classnames'

import styles from './CircleBlurredShape.module.scss'

interface CircleBlurredShapeProps {
  color?: 'solid-raspberry' | 'gradient-plum' | 'gradient-soft-plum' | 'gradient-raspberry-purple'
  style: {
    width?: string
    index?: number
    opacity?: number
    left?: string
    top?: string
    blur?: number
  }
  styleSM?: {
    display?: string
    width?: string
    left?: string
    top?: string
    blur?: number
  }
  className?: string
}

export default function CircleBlurredShape({
  color,
  style,
  styleSM,
  className,
}: CircleBlurredShapeProps) {
  return (
    <span
      className={classNames(styles.container, styles[`color-${color}`], className)}
      style={
        {
          '--width': style?.width || '800px',
          '--index': style?.index || 0,
          '--opacity': style?.opacity || 0.5,
          '--left': style?.left || '0px',
          '--top': style?.top || '0px',
          '--blur': style?.blur ? `${style?.blur}px` : '50px',
          // Small Screen
          '--display-sm': styleSM?.display ? `${styleSM?.display}` : 'initial',
          '--width-sm': styleSM?.width ? `${styleSM?.width}` : 'var(--width)',
          '--top-sm': styleSM?.top ? `${styleSM?.top}` : 'var(--top)',
          '--left-sm': styleSM?.left ? `${styleSM?.left}` : 'var(--left)',
          '--blur-sm': styleSM?.blur !== undefined ? `${styleSM?.blur}` : 'var(--blur)',
        } as CSSProperties
      }
    />
  )
}
