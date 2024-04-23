import { GhostContentAPIOptions } from '@tryghost/content-api'

export const PLACEHOLDER_BLOG_IMAGE = ''
export const GhostContentAPIConfig: GhostContentAPIOptions = {
  url: 'https://blog.archethic.net',
  key: 'aeec92562cfcb3f27993205631',
  version: 'v5.0',
}

export type SocialNetworkType =
  | 'github'
  | 'discord'
  | 'telegram'
  | 'twitter'
  | 'linkedin'
  | 'instagram'
  | 'medium'
  | 'youtube'
export const SocialNetworks: SocialNetworkType[] = [
  'github',
  'discord',
  'telegram',
  'twitter',
  'linkedin',
  'instagram',
  'medium',
  'youtube',
]

export enum InternalLinks {
  General = '#general',
  Learn = '#learn',
  Legal = '#legal',
  Home = '/',
  Developers = '/developers',
  Ecosystem = '/ecosystem',
  Investors = '/investors',
  Governance = '/governance',
  ContactUs = 'mailto:contact@archethic.net',
  WhitePaper = '/ARCHEthic_WhitePaper.pdf',
  WhitePaperNew = '/Archethic_White_Paper.pdf',
  TechnicalPaper = '/ARCHEthic_YellowPaper.pdf',
  PrivacyPolicy = '/privacy-policy',
  PrivacyPolicyWallet = '/privacy-policy-wallet',
  TermsUse = '/terms-of-use',
  BrandAssets = '/brand-assets',
  Wallet = '/wallet',
}

export enum ExternalLinks {
  // Social
  Github = 'https://github.com/archethic-foundation',
  Discord = 'https://discord.com/invite/bZv9aHN7bd',
  Telegram = 'https://t.me/ArchEthic_ENG',
  Twitter = 'https://twitter.com/archethic',
  Linkedin = 'https://www.linkedin.com/company/archethic-technologies/',
  Instagram = 'https://www.instagram.com/the_official_archethic/',
  Medium = 'https://medium.com/archethic',
  Youtube = 'https://www.youtube.com/channel/UCmP7Sg_TdBfbO1_u4EyIKzg',
  WalletIosDL = 'https://apps.apple.com/app/apple-store/id6443334906',
  WalletMacOSDL = 'https://apps.apple.com/app/archethic-wallet/id6443334906',
  WalletAndroidDL = 'https://play.google.com/store/apps/details?id=net.archethic.archethic_wallet',
  WalletWindowsDL = 'https://apps.microsoft.com/store/detail/archethic-wallet/9N33TTVRJZXF',
  WalletLinuxDL = 'https://github.com/archethic-foundation/archethic-wallet/releases/',
  // Links
  Documentation = 'https://wiki.archethic.net/',
  aeBridge = 'https://bridge.archethic.net',
  aeSwap = 'https://dex.archethic.net',
  aeHostingTestnet = 'https://aeweb.archethic.net',
  aePlaygroundTestnet = 'https://playground.archethic.net/',
  aeExplorer = 'https://mainnet.archethic.net/explorer',
  DevelopmentKit = 'https://github.com/archethic-foundation/libjs',
  Playground = 'https://playground.archethic.net/',
  Patents = 'https://wiki.archethic.net/learn/patents',
  BuyUCO = 'https://app.uniswap.org/#/swap?outputCurrency=0x8a3d77e9d6968b780564936d15b09805827c21fa&use=V2',
  Explorer = 'https://mainnet.archethic.net/explorer',
  JoinOurTeam = 'mailto:contact@archethic.net',
  InvestorsJoinUs = 'https://t.me/ArchEthic_ENG',
  WalletLastUpdate = 'https://www.youtube.com/playlist?list=PL6GQEJjcIwHChTok4CJyw3lsmlvoJLnZK',
}
