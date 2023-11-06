'use client'

import React, { useEffect, useRef, useState } from 'react'
import { ExternalLinks, InternalLinks } from '@/config'
import ArchethicBrand from '@/ui/_assets/ArchethicBrand'
import { ArrowLeftRotatedIcon } from '@/ui/_assets/icons/ArrowLeftRotatedIcon'
import { ArrowRightIcon } from '@/ui/_assets/icons/ArrowRightIcon'
import { CaretDownIcon } from '@/ui/_assets/icons/CaretDownIcon'
import { CaretUpIcon } from '@/ui/_assets/icons/CaretUpIcon'
import { Button } from '@/ui/Button/Button'
import Flex from '@/ui/Flex/Flex'
import { useOnClickOutside } from '@/utils/hooks/useOnClickOutside'
import classNames from 'classnames'
import Link from 'next/link'
import { usePathname } from 'next/navigation'

import styles from './DesktopNavigation.module.scss'

function NavDropdown() {
  const [isOpen, setIsOpen] = useState(false)
  const ref = useRef(null)

  const handleClickOutside = () => {
    setIsOpen(false)
  }

  useOnClickOutside(ref, handleClickOutside)

  return (
    <div className={styles.navDropdown} ref={ref}>
      <button onClick={() => setIsOpen((prev) => !prev)} className={styles.navDropdown_button}>
        Resources {!isOpen ? <CaretDownIcon /> : <CaretUpIcon />}
      </button>
      <Flex
        gap={12}
        className={classNames(styles.navDropdown_popover, {
          [styles.isOpen]: isOpen,
        })}
      >
        <Link href={InternalLinks.WhitePaper} target="_blank" className={styles.navDropdown_link}>
          White Paper <ArrowLeftRotatedIcon />
        </Link>
        <Link href={InternalLinks.TechnicalPaper} target="_blank" className={styles.navDropdown_link}>
          Technical Paper <ArrowLeftRotatedIcon />
        </Link>
      </Flex>
    </div>
  )
}

function NavLinkButton({ href, active, title }: { title: string; href: string; active: boolean }) {
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

export function DesktopNavigation() {
  const [state, setState] = useState<'initial' | 'scrolling' | 'pinned'>('initial')
  const [lastScrollY, setLastScrollY] = useState(0)
  const pathname = usePathname()

  const controlNavbar = () => {
    if (typeof window !== 'undefined') {
      if (window.scrollY < 70) {
        setState('initial')
      } else if (window.scrollY > lastScrollY) {
        setState('scrolling')
      } else {
        setState('pinned')
      }

      setLastScrollY(window.scrollY)
    }
  }

  useEffect(() => {
    if (typeof window !== 'undefined') {
      window.addEventListener('scroll', controlNavbar)

      // cleanup function
      return () => {
        window.removeEventListener('scroll', controlNavbar)
      }
    }
  }, [lastScrollY, controlNavbar])

  return (
    <div className={classNames(styles.container, styles[`state-${state}`])}>
      <div className={styles.brandWrapper}>
        <Link href={InternalLinks.Home} prefetch={false}>
          <ArchethicBrand />
        </Link>
      </div>

      <nav
        className={classNames(styles.navWrapper, {
          [styles.navWrapperLinkShorted]: state !== 'initial',
        })}
      >
        <NavLinkButton
          title='Developers'
          active={pathname === '/developers/'}
          href={InternalLinks.Developers}
        />
        <NavLinkButton
          title='Investors'
          active={pathname === '/investors/'}
          href={InternalLinks.Investors}
        />
        <NavLinkButton
          title='Ecosystem'
          active={pathname === '/ecosystem/'}
          href={InternalLinks.Ecosystem}
        />
        <NavLinkButton title='Governance' active={pathname === '/governance/'} href={InternalLinks.Governance} />
        <NavDropdown />
      </nav>

      <div className={styles.ctaWrapper}>
        <Button
          label='Buy UCO'
          to={ExternalLinks.BuyUCO}
          target='_blank'
          icon={<ArrowRightIcon />}
        />
      </div>
    </div>
  )
}
