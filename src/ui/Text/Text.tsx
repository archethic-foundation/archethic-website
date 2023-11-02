import React, { CSSProperties, forwardRef, PropsWithChildren } from 'react'
import classNames from 'classnames'

import styles from './Text.module.scss'

export type HTMLTag =
  | 'h1'
  | 'h2'
  | 'h3'
  | 'h4'
  | 'h5'
  | 'h6'
  | 'p'
  | 'div'
  | 'span'
  | 'small'
  | 'label'
  | 'aside'
  | 'article'
  | 'li'
  | 'dt'
  | 'dd'

export type TextColor = 'inherit' | 'raspberry-300' | 'neutral-500' | 'neutral0'

export type TextWeight = 'light' | 'normal' | 'semibold' | 'bold'

export type TextSize =
  | 'inherit'
  | 'display-extralarge'
  | 'display-large'
  | 'display-medium'
  | 'display-small'
  | 'display-extrasmall'
  | 'headline-heavy'
  | 'headline-large'
  | 'headline-medium'
  | 'headline-medium-small'
  | 'headline-regular'
  | 'text-large'
  | 'text-medium'
  | 'label-regular'

export interface TextProps {
  as?: HTMLTag
  size?: TextSize
  color?: TextColor
  style?: CSSProperties
  weight?: TextWeight
  textWrap?: boolean
  className?: string
  inView?: boolean
}

export const T = forwardRef<any, PropsWithChildren<TextProps>>(
  (
    {
      children,
      style,
      as = 'p',
      size = 'base',
      color = 'neutral0',
      weight = 'normal',
      textWrap = true,
      className,
      inView,
      ...rest
    },
    ref
  ) => {
    const Tag = as as keyof Pick<JSX.IntrinsicElements, HTMLTag>

    return (
      <Tag
        data-inview={inView}
        ref={ref}
        className={classNames(
          styles.container,
          styles[`color-${color}`],
          styles[`size-${size}`],
          styles[`weight-${weight}`],
          className,
          {
            [styles.textWrap]: textWrap,
          }
        )}
        style={style}
        {...rest}
      >
        {children}
      </Tag>
    )
  }
)
