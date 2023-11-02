import React from 'react'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { Parallax } from '@/ui/Parallax/Parallax'
import VideoCard from '@/ui/VideoCard/VideoCard'

import styles from './VideoSection.module.scss'

interface VideoSectionProps {
  className?: string
}

export default function VideoSection({ className }: VideoSectionProps) {
  return (
    <div className={styles.container}>
      <Parallax speed={0.5} id='videoCard'>
        <MaxWidthLayoutContainer className={className}>
          <div>
            <VideoCard
              videoSrc='/videos/video.mp4'
              /*videoSrc='https://preprod.archethic.net/assets/img/video.mp4'*/
              image={{
                src: '/images/home/video-cover-bg.webp',
                srcRetina: '/images/home/video-cover-bg@2x.webp',
              }}
            />
          </div>
        </MaxWidthLayoutContainer>
      </Parallax>
    </div>
  )
}
