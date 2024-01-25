'use client'

import React, { useEffect, useRef } from 'react';
import { useWindowSize } from 'react-use';
import { useHomePageStore } from '@/app/home/Home';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger';

import styles from './KeyFeatures2.module.scss';

interface KeyFeaturesProps2 {
  className?: string;
}

export default function KeyFeatures2({ className }: KeyFeaturesProps2) {
  const sections = useHomePageStore((state) => state.sections);
  const shapeARef = useRef<HTMLDivElement>(null);
  const sectionRef = useRef<HTMLDivElement>(null);
  const { height: windowHeight } = useWindowSize();

  gsap.registerPlugin(ScrollTrigger);

  useEffect(() => {
    if (!sections) {
      return;
    }

    const opacitySectionStart = sections.keyFeatures.offsetTop - windowHeight;
    const opacitySectionEnd = sections.keyFeatures.offsetTop;

    gsap.to(shapeARef.current, {
      opacity: 0,
      scrollTrigger: {
        trigger: sectionRef.current,
        start: 'top top',
        end: 'bottom bottom',
        scrub: false,
        onUpdate: (self) => {
          const opacityProgress = Math.floor(
            (self.scroll() - opacitySectionStart) /
              (opacitySectionEnd - opacitySectionStart) *
              100
          );
          const opacity = Math.min(0.97, opacityProgress / 100);
          gsap.to(shapeARef.current, { opacity: opacity, duration: 0.5 });
        },
      },
    });
  }, [sections, windowHeight]);

  return <span className={styles.bgShapeA} ref={shapeARef} />;
}
