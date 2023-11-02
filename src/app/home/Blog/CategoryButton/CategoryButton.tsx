import React, { DispatchWithoutAction } from 'react'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './CategoryButton.module.scss'

interface CategoryButtonProps {
  label?: string
  onClick: DispatchWithoutAction
  disabled?: boolean
  active?: boolean
  className?: string
}

export default function CategoryButton({
  label,
  active,
  onClick,
  className,
  disabled,
}: CategoryButtonProps) {
  return (
    <button
      disabled={disabled}
      className={classNames(styles.container, className, {
        [styles.active]: active,
      })}
      onClick={onClick}
    >
      <T as='span' size='headline-regular' weight='semibold'>
        {label}
      </T>
    </button>
  )
}
