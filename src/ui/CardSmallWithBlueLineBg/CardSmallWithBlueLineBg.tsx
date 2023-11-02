import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './CardSmallWithBlueLineBg.module.scss'

interface CardSmallWithBlueLineBgProps {
  title: string
  text: string
}

export default function CardSmallWithBlueLineBg({ title, text }: CardSmallWithBlueLineBgProps) {
  return (
    <Flex className={classNames(styles.container)} gap={16}>
      <T as='h4' size='display-extrasmall' weight='bold'>
        {title}
      </T>
      <T as='p' size='headline-medium-small'>
        {text}
      </T>
    </Flex>
  )
}
