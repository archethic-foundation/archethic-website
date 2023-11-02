import React, { useRef, useState } from 'react'
import styles from '@/app/layout/Navigation/Mobile/MobileNavigation.module.scss'
import { InternalLinks } from '@/config'
import { ArrowLeftRotatedIcon } from '@/ui/_assets/icons/ArrowLeftRotatedIcon'
import { CaretDownIcon } from '@/ui/_assets/icons/CaretDownIcon'
import { CaretUpIcon } from '@/ui/_assets/icons/CaretUpIcon'
import Flex from '@/ui/Flex/Flex'
import { useOnClickOutside } from '@/utils/hooks/useOnClickOutside'
import classNames from 'classnames'
import Link from 'next/link'

export function NavDropdown() {
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
        gap={16}
        className={classNames(styles.navDropdown_popover, {
          [styles.isOpen]: isOpen,
        })}
      >
        <Link href={InternalLinks.WhitePaper} className={styles.navDropdown_link}>
          White Paper <ArrowLeftRotatedIcon />
        </Link>
        <Link href={InternalLinks.TechnicalPaper} className={styles.navDropdown_link}>
          Technical Paper <ArrowLeftRotatedIcon />
        </Link>
      </Flex>
    </div>
  )
}
