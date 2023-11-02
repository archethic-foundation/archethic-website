'use client'

import React, { useEffect, useRef, useState } from 'react'
import { Button } from '@/ui/Button/Button'
import videojs from 'video.js'

import 'video.js/dist/video-js.css'

import styles from './VideoCard.module.scss'

interface VideoCardProps {
  videoSrc: string
  image: {
    src: string
    srcRetina: string
  }
  className?: string
}

export default function VideoCard({ videoSrc, image, className }: VideoCardProps) {
  const [showVideo, setShowVideo] = useState(false)
  const videoRef = useRef(null)

  const options = {
    autoplay: true,
    controls: true,
    sources: [
      {
        src: videoSrc,
        type: 'video/mp4',
      },
    ],
  }

  useEffect(() => {
    if (videoRef.current) {
      const player = videojs(videoRef.current, options, () => {
        console.log('Player is ready!')
      })

      return () => {
        if (player) {
          player.dispose()
        }
      }
    }
  }, [options])

  return (
    <article className={className}>
      <div className={styles.container}>
        {!showVideo && (
          <div className={styles.buttonWrapper}>
            <Button label='Play video' variant='tertiary' onClick={() => setShowVideo(true)} />
          </div>
        )}

        <div className={styles.videoWrapper}>
          {showVideo ? (
            <div data-vjs-player className={styles.player}>
              <video ref={videoRef} className='video-js' />
            </div>
          ) : (
            <>
              <span className={styles.blackLayer} />
              <img
                src={image.src}
                srcSet={`${image.srcRetina} 2x`}
                alt={''}
                className={styles.image}
              />
            </>
          )}
        </div>
      </div>
    </article>
  )
}
