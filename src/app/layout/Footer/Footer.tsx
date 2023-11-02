'use client'

import React from 'react'
import Copyrights from '@/app/layout/Footer/Copyrights/Copyrights'
import { ExternalLinks, InternalLinks } from '@/config'
import ArchethicBrand from '@/ui/_assets/ArchethicBrand'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'
import Link from 'next/link'
import { usePathname } from 'next/navigation'

import styles from './Footer.module.scss'

export function Footer() {
  const pathname = usePathname()

  return (
    <div className={styles.wrapper}>
      <MaxWidthLayoutContainer>
        <div className={styles.container}>
          <div className={styles.brand}>
            <Link href={InternalLinks.Home} prefetch={false}>
              <ArchethicBrand />
            </Link>
            <T as='p' size='headline-medium' className={styles.description}>
              Connect, collaborate, and engage with like-minded individuals in the Archethic
              community.
            </T>
          </div>
          <div className={styles.links}>
            <div className={styles.linksColumn}>
              <T
                as='h6'
                size='text-medium'
                color='neutral-500'
                weight='semibold'
                className={styles.description}
              >
                General
              </T>
              <div className={styles.linksList}>
                <Link
                  href={InternalLinks.Developers}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/developers/',
                  })}
                >
                  Developers
                </Link>
                <Link
                  href={InternalLinks.Ecosystem}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/ecosystem/',
                  })}
                >
                  Ecosystem
                </Link>
                <Link
                  href={InternalLinks.Investors}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/investors/',
                  })}
                >
                  Investors
                </Link>
              </div>
            </div>

            <div className={styles.linksColumn}>
              <T
                as='h6'
                size='text-medium'
                color='neutral-500'
                weight='semibold'
                className={styles.description}
              >
                Learn
              </T>
              <div className={styles.linksList}>
                <Link
                  href={InternalLinks.About}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/about/',
                  })}
                >
                  About
                </Link>
                <Link
                  href={ExternalLinks.Documentation}
                  target='_blank'
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/documentation/',
                  })}
                >
                  Documentation
                </Link>
              </div>
            </div>

            <div className={styles.linksColumn}>
              <T
                as='h6'
                size='text-medium'
                color='neutral-500'
                weight='semibold'
                className={styles.description}
              >
                Legal
              </T>
              <div className={styles.linksList}>
                <Link
                  href={InternalLinks.PrivacyPolicy}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/privacy-policy/',
                  })}
                >
                  Privacy Policy
                </Link>
                <Link
                  href={InternalLinks.TermsUse}
                  prefetch={false}
                  className={classNames({
                    [styles.activeLink]: pathname === '/terms-of-use/',
                  })}
                >
                  Terms of use
                </Link>
                <Link href={InternalLinks.ContactUs} prefetch={false}>
                  Contact us
                </Link>
              </div>
            </div>
          </div>
        </div>
      </MaxWidthLayoutContainer>
      <Copyrights />
    </div>
  )
}
