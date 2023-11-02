import React, { forwardRef } from 'react'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './KeyFeaturesCard.module.scss'

interface KeyFeaturesProps {
  title: string
  description: string
  className?: string
}

export const KeyFeaturesCard = forwardRef<HTMLDivElement, KeyFeaturesProps>(
  ({ title, description, className }, ref) => (
    <article ref={ref} className={classNames(styles.container, className)}>
      <T as='h1' size='display-medium' color='raspberry-300' weight='semibold'>
        {title}
      </T>

      <T as='p' size='headline-regular'>
        {description}
      </T>
    </article>
  )
)
