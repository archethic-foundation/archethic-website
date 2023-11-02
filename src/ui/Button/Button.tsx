import React, {
  AnchorHTMLAttributes,
  ButtonHTMLAttributes,
  DispatchWithoutAction,
  ReactNode,
} from 'react'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'
import Link from 'next/link'

import styles from './Button.module.scss'

export type SharedProps = {
  label?: string
  variant?: 'primary' | 'secondary' | 'tertiary'
  size?: 'sm' | 'md'
  icon?: ReactNode
  onNewTab?: boolean
  to?: string
  active?: boolean
  disabled?: boolean
  className?: string
  onClick?: DispatchWithoutAction
}

type ButtonTagProps = SharedProps & ButtonHTMLAttributes<HTMLButtonElement>
type AnchorTagProps = SharedProps & AnchorHTMLAttributes<HTMLAnchorElement>
export type ButtonProps = ButtonTagProps | AnchorTagProps

export const Button = ({
  variant = 'primary',
  size = 'md',
  icon,
  label,
  onClick,
  to,
  active,
  disabled,
  className,
  onNewTab = false,
  ...rest
}: ButtonProps) => {
  const props = {
    className: classNames(
      styles.container,
      styles[`variant-${variant}`],
      styles[`size-${size}`],
      {
        [styles['isActive']]: active,
        [styles['noLabel']]: !label,
        [styles['animeWithIcon']]: icon,
      },
      className
    ),
  }

  const ButtonContent = (
    <>
      {label && (
        <T as='span' size='text-large'>
          {label}
        </T>
      )}
      {icon}
    </>
  )

  if (to) {
    const linkProps = rest as AnchorTagProps
    return (
      <Link
        href={to}
        prefetch={false}
        {...props}
        {...linkProps}
        target={linkProps?.target ? linkProps.target : onNewTab ? '_blank' : undefined}
      >
        {ButtonContent}
      </Link>
    )
  }

  return (
    <button type='button' onClick={onClick} {...props} {...(rest as ButtonTagProps)}>
      {ButtonContent}
    </button>
  )
}
