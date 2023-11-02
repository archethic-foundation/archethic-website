import React from 'react'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import Flex from '@/ui/Flex/Flex'
import { T, TextProps } from '@/ui/Text/Text'
import { TextLink, TextLinkProps } from '@/ui/TextLink/TextLink'
import classNames from 'classnames'

import styles from './CardSmall.module.scss'

interface CardSmallProps {
  variant: 'primary' | 'secondary' | 'stats' // 'tertiary'
  counter?: string
  title: string
  text?: string
  textLink?: {
    to: string
    label: string
    color?: TextLinkProps['color']
    onNewTab?: TextLinkProps['onNewTab']
  }
  className?: string
}

export default function CardSmall({
  variant,
  counter,
  title,
  text,
  textLink,
  className,
}: CardSmallProps) {
  const titleSizeMap: Record<CardSmallProps['variant'], TextProps['size']> = {
    primary: 'headline-large',
    secondary: 'display-extrasmall',
    stats: 'headline-medium',
  }
  const titleWeightMap: Record<CardSmallProps['variant'], TextProps['weight']> = {
    primary: 'bold',
    secondary: 'bold',
    stats: 'normal',
  }

  const textSizeMap: Record<CardSmallProps['variant'], TextProps['size']> = {
    primary: 'text-medium',
    secondary: 'headline-medium-small',
    stats: 'headline-medium-small',
  }

  const flexGapMap: Record<CardSmallProps['variant'], number> = {
    primary: 16,
    secondary: 8,
    stats: 32,
  }

  const counterTextColorMap: Record<CardSmallProps['variant'], TextProps['color']> = {
    primary: 'raspberry-300',
    secondary: 'raspberry-300',
    stats: 'neutral0',
  }

  return (
    <Flex
      className={classNames(styles.container, styles[`variant-${variant}`], className)}
      gap={flexGapMap[variant]}
    >
      {counter && (
        <T
          as='h6'
          size='display-medium'
          weight='semibold'
          color={counterTextColorMap[variant]}
          className={styles.counter}
        >
          {counter}
        </T>
      )}

      <T as='h5' size={titleSizeMap[variant]} weight={titleWeightMap[variant]}>
        {title}
      </T>

      {text && (
        <T as='p' size={textSizeMap[variant]}>
          {text}
        </T>
      )}

      {textLink && (
        <TextLink
          color={textLink.color}
          label={textLink.label}
          to={textLink.to}
          onNewTab={textLink.onNewTab}
          icon={<ArrowRightIcon />}
          className={styles.button}
        />
      )}
    </Flex>
  )
}
