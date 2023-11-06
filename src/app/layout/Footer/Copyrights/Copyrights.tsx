import React from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './Copyrights.module.scss'

interface CopyrightsProps {
  className?: string
}

export default function Copyrights({ className }: CopyrightsProps) {
  return (
    <div className={classNames(className, styles.container)}>
      <hr />
      <MaxWidthLayoutContainer>
        <T as='p' size='text-medium' color='neutral-500'>
          2023 ©Archethic. All rights reserved
        </T>
      </MaxWidthLayoutContainer>
    </div>
  )
}
