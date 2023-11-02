import React, { CSSProperties } from 'react'
import { T } from '@/ui/Text/Text'
import { hashCode } from '@/utils/hashCode.utils'
import classNames from 'classnames'

import styles from './CategoryTag.module.scss'

interface CategoryButtonProps {
  tag: string
  className?: string
}

export default function CategoryTag({ tag, className }: CategoryButtonProps) {
  const tagHashcode = hashCode(tag) * 31
  const style = {
    '--text': 'hsla(' + (tagHashcode % 360) + ', 20%, 60%, 1)',
    '--bg': 'hsla(' + (tagHashcode % 360) + ', 100%, 88%, 0.2)',
  } as CSSProperties

  return (
    <T
      as='span'
      size='text-medium'
      weight='normal'
      className={classNames(styles.container, className)}
      style={style}
    >
      {tag}
    </T>
  )
}
