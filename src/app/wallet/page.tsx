"use client";

import React from "react";
import styles from "./page.module.scss";
import BackgroundShape from '@/ui/Shapes/BackgroundShape/BackgroundShape'
import Download from '@/app/wallet/Download/Download'
import Hero from '@/app/wallet/Hero/Hero'
import DnaAnimation from '@/app/home/DnaAnimation/DnaAnimation'

export default function Wallet() {
  return (
    <>
      <Hero />
      <div className={styles.topWrapper}>

        <Download />

        <BackgroundShape
          lightsLayer={<span className={styles.topWrapperLightsLayer} />}
          variant='gradient-light-to-dark-blue'
          style={{
            top: '0',
            height: 'calc(100% + 85px)',
          }}
        />
      </div>
      <DnaAnimation />
    </>
  );
}
