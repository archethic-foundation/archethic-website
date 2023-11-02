import React, { CSSProperties, PropsWithChildren } from 'react'
import classNames from 'classnames'

import styles from './Flex.module.scss'

interface FlexProps {
  id?: string
  direction?: 'column' | 'row'
  smDirection?: 'column' | 'row'
  alignItems?: 'flex-start' | 'center'
  justifyContent?: 'flex-start' | 'center'
  gap?: number
  smGap?: number
  className?: string
}

export default function Flex({
  id,
  className,
  children,
  direction = 'column',
  smDirection,
  alignItems = 'flex-start',
  justifyContent = 'flex-start',
  smGap,
  gap = 0,
}: PropsWithChildren<FlexProps>) {
  return (
    <div
      id={id}
      className={classNames(
        styles.container,
        styles[`direction-${direction}`],
        styles[`smDirection-${smDirection}`],
        styles[`alignItems-${alignItems}`],
        styles[`justifyContent-${justifyContent}`],
        className
      )}
      style={
        {
          '--lgGap': `${gap}px`,
          '--smGap': `${smGap || gap}px`,
        } as CSSProperties
      }
    >
      {children}
    </div>
  )
}
