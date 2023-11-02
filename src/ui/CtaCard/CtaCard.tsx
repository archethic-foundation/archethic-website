import React from 'react'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { Button, ButtonProps } from '@/ui/Button/Button'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './CtaCard.module.scss'

interface CtaCardProps {
  variantColor: 'black' | 'raspberry' | 'blueWaves'
  image?: {
    src: string
    srcRetina: string
  }
  imageRetina?: string
  title: string
  description: string
  button?: {
    link: string
    label: string
    variant?: ButtonProps['variant']
    onNewTab?: ButtonProps['onNewTab']
  }
  className?: string
}

export default function CtaCard({
  variantColor,
  image,
  title,
  description,
  button,
  className,
}: CtaCardProps) {
  return (
    <article
      className={classNames(styles.container, styles[`variantColor-${variantColor}`], className)}
    >
      <div className={styles.content}>
        <T as='h1' size='display-extrasmall' weight='semibold'>
          {title}
        </T>

        <T as='h2' size='headline-regular'>
          {description}
        </T>
      </div>

      {button && (
        <Button
          label={button.label}
          variant={button.variant || 'tertiary'}
          to={button.link}
          onNewTab={button.onNewTab}
          icon={<ArrowRightIcon />}
          className={styles.button}
        />
      )}

      {variantColor === 'blueWaves' ? (
        <img
          src='/images/components/ctaCard/blue-waves-bg.png'
          srcSet={`/images/components/ctaCard/blue-waves-bg@2x.png 2x`}
          alt={`Card Background - ${title}`}
          className={classNames(styles.image, styles.imageFull)}
        />
      ) : image ? (
        <img
          src={image.src}
          srcSet={`${image.srcRetina} 2x`}
          alt={`Card Background - ${title}`}
          className={styles.image}
        />
      ) : null}
    </article>
  )
}
