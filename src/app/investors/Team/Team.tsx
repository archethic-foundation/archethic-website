'use client'

import React, { useEffect, useRef } from 'react'
import TeamCard from '@/app/investors/Team/TeamCard/TeamCard'
import { ButtonSliderNav } from '@/ui/ButtonSliderNav/ButtonSliderNav'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import { register } from 'swiper/element/bundle'
// @ts-ignore
import { SwiperRef } from 'swiper/swiper-react'

import styles from './Team.module.scss'

const TEAM = [
  {
    image: {
      src: '/images/investors/team-ceo.webp',
      srcRetina: '/images/investors/team-ceo@2x.webp',
    },
    role: 'CEO',
    name: 'Sébastien Dupont',
    text: 'Steered two flagship projects at Orange over a decade: Identity Management, catering to a vast user base of 100M & Mobile Banking in Africa, where he drove growth from €10M to €4 billion in revenue. Cybersecurity Specialist with Thales for 10 years, Bitcoin Evangelist since 2013.',
  },
  {
    image: {
      src: '/images/investors/team-coo.webp',
      srcRetina: '/images/investors/team-coo@2x.webp',
    },
    role: 'COO',
    name: 'Nilesh Patankar',
    text: 'Nilesh is an ardent advocate of open-source principles and decentralization. He has assisted organizations like Mastercard and Barclays in modernizing their payment infrastructure and successfully transitioning to the cloud.',
  },
  {
    image: {
      src: '/images/investors/team-cio.webp',
      srcRetina: '/images/investors/team-cio@2x.webp',
    },
    role: 'CIO',
    name: 'Sylvain Séramy',
    text: 'With over two decades of experience, Sylvain, Chief Information Officer at Archethic, has committed his career to a leading firm specializing in the secure processing, storage, and management of sensitive data.',
  },
  {
    image: {
      src: '/images/investors/team-cco.webp',
      srcRetina: '/images/investors/team-cco@2x.webp',
    },
    role: 'CCO',
    name: 'Victor Lafforgue',
    text: 'Victor is Chief Crypto Officer, leading ecosystem launch & development. He is co-founder of a private investment company that turned $100k investment into $10M+ AUM. With a 7+ years background in crypto markets, he is a DeFi “Degen” while also advising several crypto projects.',
  },
  {
    image: {
      src: '/images/investors/team-lead-architect.webp',
      srcRetina: '/images/investors/team-lead-architect@2x.webp',
    },
    role: 'LEAD ARCHITECT',
    name: 'Samuel Manzanera',
    text: 'Samuel is the Lead Architect of the Blockchain Development Team. He specialized in solidity on ETH since 8+ years with a focus on Identity Management & Fundraising Models. Previous collaborations with industry leaders such as Michelin, Viseo, and Deloitte.',
  },
  {
    image: {
      src: '/images/investors/team-lawyer.webp',
      srcRetina: '/images/investors/team-lawyer@2x.webp',
    },
    role: 'LAWYER',
    name: 'Gérard Aubert',
    text: `Expert in corporate law, taxation, and complex international group structures. Strategist in industries including Food, Biotech, and Fintech.\nFor 6 years, partnered with Manuel CASTRO, an international tax specialist, at CCA International in Brussels.`,
  },
]

export default function Team() {
  const swiperRef = useRef<SwiperRef>(null)
  const navigationPrevRef = React.useRef(null)
  const navigationNextRef = React.useRef(null)
  const { isScreenSmall } = useBreakpoints()

  useEffect(() => {
    if (swiperRef.current) {
      register()

      const params = {
        slidesPerView: 'auto',
        spaceBetween: isScreenSmall ? 0 : 38,
        autoPlay: 2000,
        grabCursor: true,
        navigation: {
          prevEl: navigationPrevRef.current,
          nextEl: navigationNextRef.current,
        },
      }

      Object.assign(swiperRef.current, params)

      swiperRef.current.initialize()
    }
  }, [isScreenSmall])

  return (
    <>
      <MaxWidthLayoutContainer className={styles.container}>
        <div className={styles.content}>
          <Flex gap={24} smGap={16} className={styles.content_title}>
            <T as='h5' size='label-regular'>
              Team
            </T>
            <T as='h2' size='display-large' weight='semibold'>
              <span /> Team members
              <br />
              and their <br />
              <span /> <u>expertise</u>
            </T>
          </Flex>

          <div className={styles.content_text}>
            <T as='p' size='headline-medium'>
              Our team is composed of diverse individuals with expertise spanning blockchain
              technology, software development, finance, and more.
            </T>
          </div>
        </div>

        <div className={styles.sliderNav}>
          <ButtonSliderNav ref={navigationPrevRef} iconDirection='left' />
          <ButtonSliderNav ref={navigationNextRef} />
        </div>
      </MaxWidthLayoutContainer>

      <div className={styles.slider}>
        <swiper-container init={false} ref={swiperRef}>
          {TEAM.map((member, i) => (
            <swiper-slide key={i}>
              <TeamCard
                image={{
                  src: member.image.src,
                  srcRetina: member.image.srcRetina,
                }}
                role={member.role}
                name={member.name}
                text={member.text}
              />
            </swiper-slide>
          ))}
        </swiper-container>
      </div>
    </>
  )
}
