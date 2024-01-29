'use client'

import React, { useEffect, useRef, useState } from 'react';
import styles from './KeyFeatures2.module.scss';

interface KeyFeaturesProps2 {
  className?: string;
}

export default function KeyFeatures2({ className }: KeyFeaturesProps2) {
  const [opacity, setOpacity] = useState(0);
  const shapeARef = useRef(null);

  useEffect(() => {
    let requestId: number;
    const handleScroll = () => {
      const scrollY = window.scrollY || window.pageYOffset;
      const maxOpacity = 0.90;
      const scrollThreshold = window.innerHeight * 0.8;
      const newOpacity = Math.min(maxOpacity, scrollY / scrollThreshold);

      setOpacity(newOpacity);
      requestId = window.requestAnimationFrame(handleScroll);
    };

    window.addEventListener('scroll', handleScroll);

    return () => {
      window.removeEventListener('scroll', handleScroll);
      window.cancelAnimationFrame(requestId);
    };
  }, []);

  const shapeAStyle = {
    opacity: opacity,
  };

  return <span className={`${styles.bgShapeA} ${opacity > 0 ? styles.visible : ''}`} style={shapeAStyle} ref={shapeARef} />;
}