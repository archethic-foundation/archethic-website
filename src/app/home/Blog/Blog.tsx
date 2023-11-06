'use client'

import React, { useEffect, useRef, useState } from 'react'
import BlogPost from '@/app/home/Blog/BlogPost/BlogPost'
import CategoryButton from '@/app/home/Blog/CategoryButton/CategoryButton'
import { GhostContentAPIConfig, PLACEHOLDER_BLOG_IMAGE } from '@/config'
import { ButtonSliderNav } from '@/ui/ButtonSliderNav/ButtonSliderNav'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import GhostContentAPI, { PostsOrPages } from '@tryghost/content-api'
import classNames from 'classnames'
import { register } from 'swiper/element/bundle'
// @ts-ignore
import { SwiperRef } from 'swiper/swiper-react'

import styles from './Blog.module.scss'

interface BlogProps {
  className?: string
}

interface Tag {
  name: string
  slug: string
}

interface Post {
  id: string
  title: string
}

const TAGS: Tag[] = [
  {
    name: 'Global',
    slug: 'global',
  },
  {
    name: 'Tech Update',
    slug: 'tech-update',
  },
  {
    name: 'Partnership',
    slug: 'partnership',
  },
]

interface PostsByTag {
  [key: string]: PostsOrPages
}

const api = new GhostContentAPI(GhostContentAPIConfig)

export default function Blog({ className }: BlogProps) {
  // Query
  const [postsByTag, setPostsByTag] = useState<PostsByTag>({})
  const [selectedTag, setSelectedTag] = useState<string>('global');
  // Slider
  const swiperRef = useRef<SwiperRef>(null)
  const navigationPrevRef = React.useRef(null)
  const navigationNextRef = React.useRef(null)
  const { isScreenSmall } = useBreakpoints()

  // Query
  useEffect(() => {
    const fetchPosts = async () => {
      const filter = selectedTag === 'recent' ? {} : { filter: `tags:${selectedTag}` };
      const posts = await api.posts.browse({ limit: 10, ...filter });
      setPostsByTag(prevPostsByTag => ({
        ...prevPostsByTag,
        [selectedTag]: posts
      }));
    };

    fetchPosts();
  }, [selectedTag]);

  // Slider
  useEffect(() => {
    if (swiperRef.current) {
      register()

      const params = {
        slidesPerView: 'auto',
        spaceBetween: isScreenSmall ? 0 : 38,
        autoPlay: 2000,
        grabCursor: true,
        freeMode: !isScreenSmall,
        navigation: {
          prevEl: navigationPrevRef.current,
          nextEl: navigationNextRef.current,
        },
      }

      Object.assign(swiperRef.current, params)

      swiperRef.current.initialize()
    }
  }, [isScreenSmall, postsByTag])

  useEffect(() => {
    if (swiperRef.current && swiperRef.current.swiper) {
      swiperRef.current.swiper.slideTo(0)
    }
  }, [selectedTag])

  return (
    <div className={classNames(className, styles.content)}>
      <MaxWidthLayoutContainer>
        <div className={styles.content}>
          <div className={styles.titleWrapper}>
            <T as='h5' size='label-regular' className={styles.subtitle}>
              Blog
            </T>
            <T as='h2' size='display-large' weight='semibold'>
              Our latest updates
            </T>
          </div>

          <T as='p' size='headline-medium' className={styles.description}>
            Developers, investors, crypto-enthusiasts and everyday users around the world are
            working together to build the foundation of our ecosystem.
          </T>

          <div className={styles.sliderActions}>
            <div className={styles.sliderCategories}>
              {TAGS?.map((tag) => (
                <CategoryButton
                  key={`blog-tag-${tag.slug}`}
                  active={tag.slug === selectedTag}
                  label={tag.name}
                  onClick={() => setSelectedTag(tag.slug)}
                />
              ))}
            </div>
            <div className={styles.sliderNav}>
              <ButtonSliderNav ref={navigationPrevRef} iconDirection='left' />
              <ButtonSliderNav ref={navigationNextRef} />
            </div>
          </div>
        </div>
      </MaxWidthLayoutContainer>

      <div className={styles.slider}>
        {postsByTag[selectedTag] && (
          <swiper-container init={false} ref={swiperRef}>
            {postsByTag[selectedTag].map((post, i) => (
              <swiper-slide key={i}>
                <BlogPost
                  feature_image={post.feature_image || PLACEHOLDER_BLOG_IMAGE}
                  date={post.published_at}
                  title={post.title}
                  excerpt={post.excerpt}
                  tag={post.primary_tag}
                  link={post.url}
                />
              </swiper-slide>
            ))}
          </swiper-container>
        )}
      </div>
    </div>
  )
}
