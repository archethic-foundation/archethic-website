import React, { useEffect, useRef } from 'react'
import SectionPrimary from '@/ui/SectionPrimary/SectionPrimary'
import { T } from '@/ui/Text/Text'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import { register } from 'swiper/element/bundle'
// @ts-ignore
import { SwiperRef } from 'swiper/swiper-react'

import styles from './JoinUs.module.scss'

interface CardProps {
  title: string
  text: string
}

const CARDS = [
  {
    title: 'Simplified language',
    text: 'Developers can learn to code Dapps within days',
  },
  {
    title: 'Editable code',
    text: 'Ability to update smart contracts after deployment',
  },
  {
    title: 'Automated triggers',
    text: 'Self triggered by internal or external events',
  },
  {
    title: 'Off-chain data retrieval',
    text: 'Make a decision based on external data',
  },
  {
    title: 'Native oracle',
    text: 'Access to external data without third-parties oracle',
  },
  {
    title: 'Multi-owner delegation',
    text: 'Enabling multiple parties to delegate control or decision-making power',
  }
]

function Card({ title, text }: CardProps) {
  return (
    <div className={styles.card}>
      <T as='h2' size='display-extrasmall' weight='bold' color='raspberry-300'>
        {title}
      </T>
      <T as='p' size='headline-regular'>
        {text}
      </T>
    </div>
  )
}

export default function JoinUs() {
  const swiperRef = useRef<SwiperRef>(null)
  const { isScreenSmall } = useBreakpoints()

  useEffect(() => {
    if (swiperRef.current) {
      register()

      const params = {
        grabCursor: true,
        freeMode: true,
        spaceBetween: isScreenSmall ? 0 : 24,
        slidesPerView: 'auto',
      }

      Object.assign(swiperRef.current, params)

      swiperRef.current.initialize()
    }
  }, [isScreenSmall])

  return (
    <div className={styles.wrapper}>
      <div className={styles.container}>
        <SectionPrimary id='buildWithUs' backgroundImage='dottedWave'>
          <div className={styles.title}>
            <T as='h5' size='label-regular'>
              Join us
            </T>
            <T as='h2' size='display-large' weight='semibold'>
              Build with us
            </T>
            <T as='p' size='headline-regular'>
              Archethic smart-contracts expand developers boundaries enabling them to create a new
              generation of services.
            </T>
          </div>

          <div className={styles.cardsSlider}>
            <swiper-container init={false} ref={swiperRef}>
              {CARDS.map((card, i) => (
                <swiper-slide key={i}>
                  <Card title={card.title} text={card.text} />
                </swiper-slide>
              ))}
            </swiper-container>
          </div>

        </SectionPrimary>
      </div>
    </div>
  )
}
