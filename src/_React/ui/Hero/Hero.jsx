
import React from 'react'

import classNames from 'classnames'

import styles from './Hero.module.scss'


export default function Hero({ className }) {

  return (
    <>
      <section id='hero' className={classNames((styles).container, className)} >
      </section >
    </>
  )
}
