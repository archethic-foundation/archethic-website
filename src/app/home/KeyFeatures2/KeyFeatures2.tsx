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
    const handleScroll = () => {
      const scrollY = window.scrollY || window.pageYOffset;
      const maxOpacity = 0.92;
      
      // Calculer le seuil de défilement à partir de 80% de la hauteur initiale de l'écran (en vh)
      const scrollThreshold = (window.innerHeight * 0.8);
      
      // Calculer l'opacité en fonction du défilement
      const newOpacity = Math.min(maxOpacity, scrollY / scrollThreshold);
      
      setOpacity(newOpacity);
    };

    window.addEventListener('scroll', handleScroll);

    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []);

  const shapeAStyle = {
    opacity: opacity,
  };

  return <span className={`${styles.bgShapeA} ${opacity > 0 ? styles.visible : ''}`} style={shapeAStyle} ref={shapeARef} />;
}