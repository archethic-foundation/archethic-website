import React, { PropsWithChildren } from 'react'
import classNames from 'classnames'

import styles from './MaxWidthLayoutContainer.module.scss'

interface SectionProps {
  id?: string
  className?: string
  as?: 'div' | 'section'
  inView?: boolean
}

export function MaxWidthLayoutContainer({
  children,
  id,
  className,
  as = 'div',
  inView,
}: PropsWithChildren<SectionProps>) {
  const Tag = as as keyof Pick<JSX.IntrinsicElements, NonNullable<SectionProps['as']>>

  return (
    <Tag data-inview={inView} id={id} className={classNames(styles.container, className)}>
      {children}
    </Tag>
  )
}
