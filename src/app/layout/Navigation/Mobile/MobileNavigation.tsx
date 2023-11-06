'use client'

import React, { useEffect, useState } from 'react'
import { NavDropdown } from '@/app/layout/Navigation/Mobile/NavDropdown'
import { NavLinkButton } from '@/app/layout/Navigation/Mobile/NavLinkButton'
import { InternalLinks } from '@/config'
import ArchethicBrand from '@/ui/_assets/ArchethicBrand'
import { useLockedBody } from '@/utils/hooks/useLockedBody'
import classNames from 'classnames'
import Link from 'next/link'
import { usePathname } from 'next/navigation'

import styles from './MobileNavigation.module.scss'

export function MobileNavigation() {
  const [state, setState] = useState<'open' | 'close'>('close')
  const [eventState, setEventState] = useState<'scrolling' | 'pinned'>('pinned')
  const [lastScrollY, setLastScrollY] = useState(0)
  const [, setLocked] = useLockedBody()
  const pathname = usePathname()

  const controlNavbar = () => {
    if (typeof window !== 'undefined') {
      if (window.scrollY < 10) {
        setEventState('pinned')
      } else {
        setEventState('scrolling')
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
  }, [lastScrollY])

  useEffect(() => {
    setLocked(state === 'open')
  }, [setLocked, state])

  useEffect(() => {
    setState('close')
  }, [pathname])

  return (
    <div
      className={classNames(
        styles.container,
        styles[`event-${eventState}`],
        styles[`state-${state}`]
      )}
    >
      <div className={styles.brand}>
        <Link href={InternalLinks.Home} prefetch={false}>
          <ArchethicBrand />
        </Link>
      </div>

      <div className={styles.navTrigger}>
        <button
          className={classNames(styles.navTriggerButton, {
            [styles.isOpen]: state === 'open',
          })}
          onClick={() => setState((prev) => (prev === 'open' ? 'close' : 'open'))}
        >
          <svg
            width='22'
            height='22'
            viewBox='0 0 22 22'
            fill='none'
            xmlns='http://www.w3.org/2000/svg'
          >
            <line y1='4.5' x2='22' y2='4.5' stroke='white' />
            <line y1='10.5' x2='22' y2='10.5' stroke='white' />
            <line y1='16.5' x2='22' y2='16.5' stroke='white' />
          </svg>
        </button>
      </div>

      <nav
        className={classNames(styles.nav, {
          [styles.showButtons]: state === 'open',
        })}
      >
        <NavLinkButton title='Governance' active={pathname === '/governance/'} href={InternalLinks.Governance} />
        <NavLinkButton
          title='Developers'
          active={pathname === '/developers/'}
          href={InternalLinks.Developers}
        />
        <NavLinkButton
          title='Ecosystem'
          active={pathname === '/ecosystem/'}
          href={InternalLinks.Ecosystem}
        />
        <NavLinkButton
          title='Investors'
          active={pathname === '/investors/'}
          href={InternalLinks.Investors}
        />
        <NavDropdown />
      </nav>

      <img
        src='/images/mobile-navigation-bg.webp'
        alt={''}
        className={classNames(styles.bg, {
          [styles.showBg]: state === 'open',
        })}
      />
    </div>
  )
}
