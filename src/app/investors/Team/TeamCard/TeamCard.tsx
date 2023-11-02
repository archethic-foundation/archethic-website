import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './TeamCard.module.scss'

interface TeamCardProps {
  image: {
    src: string
    srcRetina: string
  }
  role: string
  name: string
  text: string
  className?: string
}

export default function TeamCard({ image, role, name, text, className }: TeamCardProps) {
  return (
    <article className={classNames(styles.container, className)}>
      <div className={styles.media}>
        <img src={image.src} srcSet={`${image.srcRetina} 2x`} alt='team card image' />
      </div>

      <Flex gap={12} className={styles.content}>
        <T as='h3' size='text-medium'>
          {role}
        </T>

        <T as='h1' size='headline-large' weight='bold'>
          {name}
        </T>

        <T as='p' size='text-medium'>
          {text}
        </T>
      </Flex>
    </article>
  )
}
