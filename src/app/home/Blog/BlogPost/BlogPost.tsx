import React from 'react'
import { T } from '@/ui/Text/Text'
import { formatDate } from '@/utils/date'
import { Nullable, Tag } from '@tryghost/content-api'
import classNames from 'classnames'

import styles from './BlogPost.module.scss'

interface BlogPostProps {
  feature_image: string
  date?: Nullable<string> | undefined
  title?: string
  excerpt?: string
  tag: Nullable<Tag> | undefined
  className?: string
  link: string | undefined
}

export default function BlogPost({
  feature_image,
  date,
  title,
  excerpt,
  tag,
  className,
  link,
}: BlogPostProps) {
  return (

    <article className={classNames(styles.container, className)}>
      <a href={link} target="_blank" rel="noopener noreferrer">


        <div className={styles.media}>
          <img src={feature_image} alt='' />
        </div>

        <div className={styles.content}>
          {date && (
            <T as='div' size='text-medium' weight='light'>
              <time dateTime={date}>{formatDate(date)}</time>
            </T>
          )}

          {title && (
            <T as='h1' size='headline-heavy' weight='semibold'>
              {title}
            </T>
          )}

          {excerpt && (
            <T as='p' size='text-medium' weight='normal' className={styles.description}>
              {excerpt}
            </T>
          )}
        </div>
      </a>

      {/* <div className={styles.footer}>{tag && <CategoryTag tag={String(tag)} />}</div>*/}

    </article >

  )
}
