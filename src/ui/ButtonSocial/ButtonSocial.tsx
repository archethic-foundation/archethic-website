import React from 'react'
import { ExternalLinks, SocialNetworkType } from '@/config'
import { DiscordIcon } from '@/ui/_assets/brands/DiscordIcon'
import { GithubIcon } from '@/ui/_assets/brands/GithubIcon'
import { InstagramIcon } from '@/ui/_assets/brands/InstagramIcon'
import { LinkedinIcon } from '@/ui/_assets/brands/LinkedinIcon'
import { MediumIcon } from '@/ui/_assets/brands/MediumIcon'
import { TelegramIcon } from '@/ui/_assets/brands/TelegramIcon'
import { TwitterIcon } from '@/ui/_assets/brands/TwitterIcon'
import { YoutubeIcon } from '@/ui/_assets/brands/YoutubeIcon'
import { T } from '@/ui/Text/Text'
import classNames from 'classnames'

import styles from './ButtonSocial.module.scss'

interface ButtonSocialProps {
  app: SocialNetworkType
  className?: string
}

const url: Record<SocialNetworkType, string> = {
  github: ExternalLinks.Github,
  discord: ExternalLinks.Discord,
  telegram: ExternalLinks.Telegram,
  twitter: ExternalLinks.Twitter,
  linkedin: ExternalLinks.Linkedin,
  instagram: ExternalLinks.Instagram,
  medium: ExternalLinks.Medium,
  youtube: ExternalLinks.Youtube,
}

const name: Record<SocialNetworkType, string> = {
  github: 'Github',
  discord: 'Discord',
  telegram: 'Telegram',
  twitter: 'Twitter',
  linkedin: 'Linkedin',
  instagram: 'Instagram',
  medium: 'Medium',
  youtube: 'Youtube',
}

const icon = {
  github: (
    <>
      <GithubIcon />
    </>
  ),
  discord: <DiscordIcon />,
  telegram: <TelegramIcon />,
  twitter: <TwitterIcon />,
  linkedin: <LinkedinIcon />,
  instagram: <InstagramIcon />,
  medium: <MediumIcon />,
  youtube: <YoutubeIcon />,
}

export default function ButtonSocial({ app, className }: ButtonSocialProps) {
  return (
    <a href={url[app]} target="_blank" className={classNames(styles.container, className)}>
      {icon[app]}
      <T as='span' size='headline-medium'>
        {name[app]}
      </T>
    </a>
  )
}
