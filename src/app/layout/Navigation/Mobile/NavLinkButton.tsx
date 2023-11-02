import React from 'react'
import styles from '@/app/layout/Navigation/Mobile/MobileNavigation.module.scss'
import classNames from 'classnames'
import Link from 'next/link'

export function NavLinkButton({
  href,
  active,
  title,
}: {
  title: string
  href: string
  active: boolean
}) {
  return (
    <Link
      href={href}
      className={classNames(styles.navLinkButton, {
        [styles.active]: active,
      })}
    >
      {title}
    </Link>
  )
}
