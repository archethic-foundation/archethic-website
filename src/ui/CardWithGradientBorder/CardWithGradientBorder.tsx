'use client'

import React, { useState } from 'react'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button, ButtonProps } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './CardWithGradientBorder.module.scss'

interface CardWithGradientBorderProps {
  label: string
  title: string
  text: string
  button?: {
    link: string
    label: string
    variant?: ButtonProps['variant']
    onNewTab?: ButtonProps['onNewTab']
  }
  image?: 'rightTopCorner' | 'rightBottom'
  className?: string
}

export default function CardWithGradientBorder({
  label,
  title,
  text,
  button,
  image,
  className,
}: CardWithGradientBorderProps) {
  const [hovered, setHovered] = useState(false)
  const imageSrcMap: Record<
    NonNullable<CardWithGradientBorderProps['image']>,
    { src: string; src2x: string }
  > = {
    rightTopCorner: {
      src: '/images/shared/medium-brand-icon-rotated.png',
      src2x: '/images/shared/medium-brand-icon-rotated@2x.png',
    },
    rightBottom: {
      src: '/images/shared/xx.png',
      src2x: '/images/shared/xx@2x.png',
    },
  }

  return (
    <Flex
      gap={24}
      smGap={16}
      className={classNames(
        styles.container,
        {
          [styles.hovered]: hovered,
        },
        className
      )}
    >
      <T as='p' size='text-large'>
        {label}
      </T>
      <T as='h4' size='display-medium' weight='semibold'>
        {title}
      </T>
      <T as='p' size='headline-medium-small'>
        {text}
      </T>

      {button && (
        <Button
          label={button.label}
          variant={button.variant || 'tertiary'}
          to={button.link}
          onNewTab={button.onNewTab}
          icon={<ArrowRightIcon />}
          className={styles.button}
          onMouseEnter={() => setHovered(true)}
          onMouseLeave={() => setHovered(false)}
        />
      )}

      {image && (
        <img
          src={imageSrcMap[image].src}
          srcSet={`${imageSrcMap[image].src2x} 2x`}
          className={styles[`imageLayout-${image}`]}
          alt='Card image'
        />
      )}
    </Flex>
  )
}
