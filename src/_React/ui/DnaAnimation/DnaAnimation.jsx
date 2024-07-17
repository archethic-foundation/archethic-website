'use client'

import React, {lazy} from 'react'
import classNames from 'classnames'

import * as styles from './DnaAnimation.module.scss'
// import DNAScene from "../canvas/DNAScene";

const DNAScene = lazy(() => import("../../canvas/DNAScene.jsx"));

export default function DnaAnimation({ className }) {
  return (
    <div  className={classNames((styles).container, className)}>
      <DNAScene />
    </div>
  )
}
