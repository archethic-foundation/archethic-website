import React from 'react'
import { ButtonProps } from '@/ui/Button/Button'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'
import styles from './CtaCardApp.module.scss'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'

interface CtaCardAppProps {
  variantColor: 'black' | 'raspberry'
  title: string
  description: string
  env: string
  button?: {
    link: string
    label: string
    variant?: ButtonProps['variant']
    onNewTab?: ButtonProps['onNewTab']
  }
  className?: string
}

export default function CtaCardApp({
  variantColor,
  title,
  description,
  env,
  button,
  className,
}: CtaCardAppProps) {
  return (


    <article className={classNames(styles.container, styles[`variantColor-${variantColor}`], className)} >
      <div>
        <a href={button?.link} target="_blank" rel="noopener noreferrer">

          <div className={styles.content}>
            <div className={styles.header}>
              <T as='h1' size='display-extrasmall' weight='semibold'>
                <u>{title}</u>
              </T>
              <T as='span' color={'raspberry-300'} className={styles[`color-${'raspberry-300'}`]}>
                <ArrowRightIcon />
              </T>
            </div>
            <T as='h2' size='headline-regular'>
              {description}
            </T>
            <T as='h5'>
              {env}
            </T>
          </div>
        </a>
      </div>
    </article >
  )
}
