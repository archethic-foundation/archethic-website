'use client'

import React, { DispatchWithoutAction, forwardRef } from 'react'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import classNames from 'classnames'

import styles from './ButtonSliderNav.module.scss'

interface ButtonSliderNavProps {
  iconDirection?: 'left' | 'right'
  onClick?: DispatchWithoutAction
  disabled?: boolean
  className?: string
}

export const ButtonSliderNav = forwardRef<HTMLButtonElement, ButtonSliderNavProps>(
  ({ onClick, className, disabled, iconDirection = 'right' }, ref) => {
    return (
      <button
        ref={ref}
        disabled={disabled}
        className={classNames(styles.container, {
          [styles.reverse]: iconDirection === 'left',
        })}
      >
        <i>
          <ArrowRightIcon />
        </i>
      </button>
    )
  }
)
