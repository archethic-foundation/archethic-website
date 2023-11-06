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
  linkedln: string
  className?: string
}

export default function TeamCard({ image, role, name, text, linkedln, className }: TeamCardProps) {
  const linkedInContent = linkedln !== '#' ? (
    <a href={linkedln} target="_blank" rel="noopener noreferrer">
      <svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 32 32' fill='none'>
        <path
          d='M1.72656 4.78709C1.72656 3.87732 2.04499 3.12677 2.68181 2.53545C3.31862 1.9441 4.14652 1.64844 5.16544 1.64844C6.16618 1.64844 6.97584 1.93954 7.59448 2.5218C8.2313 3.12224 8.54972 3.90461 8.54972 4.86897C8.54972 5.74233 8.24042 6.47012 7.62177 7.05238C6.98496 7.65282 6.14797 7.95304 5.11085 7.95304H5.08356C4.08282 7.95304 3.27316 7.65282 2.65451 7.05238C2.03587 6.45194 1.72656 5.69684 1.72656 4.78709ZM2.08137 28.6682V10.4367H8.14034V28.6682H2.08137ZM11.4973 28.6682H17.5563V18.488C17.5563 17.8512 17.6291 17.3599 17.7746 17.0142C18.0294 16.3956 18.416 15.8724 18.9346 15.4449C19.4531 15.0173 20.1036 14.8035 20.886 14.8035C22.9239 14.8035 23.9428 16.1772 23.9428 18.9247V28.6682H30.0017V18.2151C30.0017 15.5222 29.3649 13.4798 28.0913 12.0879C26.8176 10.696 25.1346 9.99999 23.0421 9.99999C20.695 9.99999 18.8663 11.0098 17.5563 13.0295V13.0841H17.529L17.5563 13.0295V10.4367H11.4973C11.5337 11.0189 11.5519 12.8293 11.5519 15.8679C11.5519 18.9065 11.5337 23.1732 11.4973 28.6682Z'
          fill='currentColor'
        />
      </svg>
    </a>
  ) : (
    <div style={{ width: '22px', height: '22px' }}></div>
  );

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

        {linkedInContent}
        <T as='p' size='text-medium'>
          {text}
        </T>

      </Flex>
    </article>
  )
}
