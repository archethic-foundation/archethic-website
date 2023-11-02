import React, { PropsWithChildren } from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import classNames from 'classnames'

import styles from './SectionSecondary.module.scss'

interface SectionSecondaryProps {
  id?: string
  as?: 'div' | 'section'
  className?: string
}

export default function SectionSecondary({
  id,
  className,
  as = 'div',
  children,
}: PropsWithChildren<SectionSecondaryProps>) {
  const Tag = as as keyof Pick<JSX.IntrinsicElements, NonNullable<SectionSecondaryProps['as']>>

  return (
    <Tag id={id} className={styles.section}>
      <MaxWidthLayoutContainer>
        <div className={styles.container}>
          <div className={classNames(styles.content, className)}>{children}</div>
          <div className={styles.backgroundImage} />
        </div>
      </MaxWidthLayoutContainer>
    </Tag>
  )
}
