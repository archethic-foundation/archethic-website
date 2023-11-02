import React, { PropsWithChildren } from 'react'
import Flex from '@/ui/Flex/Flex'
import classNames from 'classnames'

import styles from './RoadmapCard.module.scss'

interface CardWithGradientBorderProps {
  hasBackground?: boolean
  className?: string
}

export default function RoadmapCard({
  children,
  hasBackground,
  className,
}: PropsWithChildren<CardWithGradientBorderProps>) {
  return (
    <Flex gap={16} className={classNames(styles.container, className)}>
      {children}
      {hasBackground && <span className={styles.background} />}
    </Flex>
  )
}
