'use client'

import React, { AnchorHTMLAttributes, ReactNode } from 'react'
import { T, TextProps } from '@/ui/Text/Text'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import classNames from 'classnames'
import Link from 'next/link'

import styles from './TextLink.module.scss'

export interface TextLinkProps extends AnchorHTMLAttributes<HTMLAnchorElement> {
  size?: 'md' | 'lg'
  color?: TextProps['color']
  label?: string
  icon?: ReactNode
  onNewTab?: boolean
  to: string
  className?: string
}

export const TextLink = ({
  size = 'md',
  color = 'neutral0',
  icon,
  label,
  onClick,
  to,
  className,
  onNewTab = false,
  ...rest
}: TextLinkProps) => {
  const { isScreenSmall } = useBreakpoints()

  const props = {
    className: classNames(
      styles.container,
      {
        [styles['noLabel']]: !label,
        [styles['animeWithIcon']]: icon,
      },
      className
    ),
  }

  const textSizeMap: Record<NonNullable<TextLinkProps['size']>, TextProps['size']> = {
    md: isScreenSmall ? 'headline-regular' : 'text-large',
    lg: 'headline-regular',
  }

  const ButtonContent = (
    <T as='span' size={textSizeMap[size]} color={color} className={styles[`color-${color}`]}>
      {label}
      {icon}
    </T>
  )

  return (
    <Link href={to} prefetch={false} {...props} {...rest} target={onNewTab ? '_blank' : undefined}>
      {ButtonContent}
    </Link>
  )
}
