'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function TermsOfUseDeFi() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Legal Conditions of Use of Services Made Available Through the Archethic Public Blockchain
          </T>

          <T as='h2' size='headline-medium'>
            Last modification: May 12, 2024
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <p>The Archethic Public Blockchain is an autonomously governed intangible common good, consisting partly of a network of decentralized autonomous computers (Decentralized Autonomous Network, DAN), and partly of a DAO (Decentralized Autonomous Organization) made up of individuals (developers, users) who guide and co-validate with the DAN itself all modifications made to the DAN.</p>
              <br />
              <p>THE USE OF THE ARCHETHIC BLOCKCHAIN, DEFI SERVICES, AND GENERALLY ALL SERVICES HOSTED BY THE ARCHETHIC BLOCKCHAIN ARE PROVIDED &quot;AS IS&quot;, AT YOUR OWN RISK, AND WITHOUT ANY WARRANTIES OF ANY KIND.</p>
              <br />
              <p><strong>1. Liability</strong><br />There is no applicable legislation or legal entity responsible for the provision of services available on the DAN. The DAN consists of computer programs subject only to the law of its source code, which is freely available for consultation before use and developed by and for the community.</p>
              <p>For a proper understanding and application of the legal framework, these terms of use must be accepted before any use of the services provided by the DAN. It is reminded that any computer system may contain security flaws or programming errors that could lead to the loss of assets involved. Similarly, it is reminded that proper use of the services remains solely the responsibility of the user. Thus, no legislation or legal entity can be held accountable for an error during the use of the services provided by the DAN.
                Finally, it is reminded that any cryptographic system relies on the necessity to keep one&quot;s cryptographic private key secret and that the services used cannot be blamed if it is disclosed.</p>
              <p>By accessing or using any of the services, you signify that you have read, understood, and agreed to be bound by this agreement in its entirety. If you do not agree, you are not authorized to use them.</p>
              <p>To access or use any of the services provided by the Archethic Public Blockchain, you must comply with the applicable regulations of your jurisdiction. Consequently, you declare that you are at least the age of majority in your jurisdiction (e.g., 18 years) and that you have all the rights, powers, and authority to enter into and comply with the terms and conditions of this Agreement on your behalf and on behalf of any company or legal entity for which you may access or use the Interface.</p>
              <p>You further declare that you are not (a) subject to economic or trade sanctions administered or enforced by any government authority or otherwise designated on a list of prohibited or restricted parties, or (b) a citizen, resident, or organized in a jurisdiction or territory that is subject to comprehensive national, territorial, or regional economic sanctions by the United States or the European Union. Finally, you declare that your access and use of any of our services will fully comply with all applicable laws and regulations, and that you will not access or use any of our services to conduct, promote, or facilitate any illegal activity.</p>
              <br />
              <p><strong>2. Terms of Use of Archethic&quot;s DeFi Services</strong><br />
                In the case of decentralized financial services (DeFi), the source code and smart contracts are the only participants in the various procedures. For example, in the case of &quot;bridges&quot; made available (cryptocurrency gateways from one blockchain to another), the mechanism used relies on the Atomic Swap method, in which the user remains the sole master of operations, and in which there are no other stakeholders than the user himself equipped with his private key and the blockchains involved.</p>
              <p>
                The terms of use herein explain the terms and conditions under which you can access and use the decentralized finance services (&quot;DeFi Services&quot;, &quot;DeFi Products&quot;) provided by the autonomous and decentralized network of the Archethic Public Blockchain. The Services should include, but are not limited to:
              </p> <ul style={{ paddingLeft: '40px' }}>
                <li>(a) aeBridge: a user interface for bi-directional transfer of digital assets between EVM-compatible or non-compatible blockchains and the Archethic Public Blockchain;</li>
                <li>(b) aeSwap or DEX: a user interface for decentralized exchanges hosted on the Archethic Public Blockchain itself and on the wallet (&quot;Archethic Wallet&quot; or &quot;aeWallet&quot;);</li>
                <li>(c) Archethic Wallet or aeWallet: The native Archethic wallet management software (&quot;Archethic Wallet&quot;, &quot;aeWallet&quot;) for managing cryptocurrency assets (available on Mobile, Windows, Linux, Mac, and Google Chrome).</li>
              </ul>
              <br />
              <p><strong>3. Special Cases of Liquidity Pools</strong><br />
                Liquidity Pools are a subset of decentralized finance (DeFi) services, particularly the DEX (decentralized cryptocurrency exchange platform), where exchanges can only be made through liquidity pools. Anyone is free to provide liquidity between two cryptocurrencies of their choice, for example: UCO and ETH or ETH and BTC, etc.</p>
              <p>
                The Archethic DEX thus differentiates between two types of liquidity pools: those whose tokens or counterparties have been verified by the Archethic DAO as a reliable project (notified by an icon <img src={'/images/shared/verified-icon.png'} alt='verified'></img>), and those that have not been verified and for which you take full responsibility to perform all necessary checks before use.
              </p>
              <p>
                Also, even in the case of pools verified by the Archethic DAO, and as previously mentioned, any computer system may contain security flaws or programming errors that could lead to the loss of assets involved, hence no one can be held liable in case of loss or blocking of assets.
              </p>
              <br />
              <p><strong>4. Non-Exhaustive List of Services of the Archethic Public Blockchain</strong></p>
              <p><strong>4.1 aeBridge/aeSwap</strong><br />
                The Interface provides a computer means to decentralized protocols on the Archethic public blockchain that allows users to transfer digital assets between blockchains (the &quot;aeBridge protocol&quot;) or to exchange certain compatible digital assets (the &quot;aeSwap protocol&quot;).
              </p>
              <p>The interface is distinct from the protocol and is one of the means, but not exclusive, to access the protocol. Each protocol includes open source or available source self-executing smart contracts that are deployed on the Archethic public blockchain.
              </p>THE DEFI PROTOCOL IS PROVIDED &quot;AS IS&quot;, AT YOUR OWN RISK, AND WITHOUT ANY WARRANTIES OF ANY KIND.
              <p>
                No developer or entity involved in the creation of the DeFi protocol will be liable for any claim or damage associated with your use, inability to use, or your interaction with other users of the DeFi protocol, including any direct, indirect, incidental, special, exemplary, punitive, or consequential damages, or loss of profits, cryptocurrencies, tokens, or any other value.
              </p>
              <p>
                The aeBridge protocol has been deployed on EVM-compatible and Archethic blockchains, while the aeSwap protocol is exclusive to the Archethic Public Blockchain. Please note that digital assets from EVM blockchains that have been &quot;bridged&quot; or &quot;wrapped&quot; to function on the blockchain are distinct from the original main network EVM asset.
              </p>
              <p>
                In the case of aeBridge, to access the Interface, you must use non-custodial wallet software, which allows you to interact with public blockchains (an EVM-compatible wallet and an Archethic-compatible wallet). Your relationship with these non-custodial wallet providers is governed by the applicable service terms.
              </p>
              <br />
              <p>
                <strong>4.2 The Archethic Wallet</strong><br />
                The Archethic Wallet allows storing digital assets; displaying addresses and information that are part of the digital asset networks and broadcast transactions; signing Bridge or DEX transactions; and executing any additional service available on the Archethic Public Blockchain.

                Aside from the user himself, no entity backs up or controls the content of your wallet so no one can be able to recover or transfer its content.
                You can consult the information and conditions available at: <u><a href="https://www.archethic.net/wallet/" target="_blank">https://www.archethic.net/wallet/</a></u>.
              </p>
              <br />
              <p>
                <strong>4.3 Third-Party Services and Content</strong><br />
                When you use any of the services made available from the Archethic Public Blockchain, you may also use the products, services, or content of one or more third parties. Your use of these third-party products, services, or content may be subject to separate policies, terms of use, and fees from these third parties, and you agree to comply with and be responsible for these policies, terms of use, and fees, as applicable.
                <br />
                We implement and maintain reasonable administrative, physical, and technical security measures to help protect data against loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction. However, transmission via the Internet is not entirely secure, and we cannot guarantee the security of your information. You are responsible for all your activities on the Services, including the security of your blockchain network addresses, your cryptocurrency wallets, and their cryptographic keys.</p>
              <br />
              <p><strong>5. Changes to this Agreement or Our Services</strong></p>
              <p><strong>5.1 Changes to this Agreement</strong><br />
                These terms of use will be regularly updated, and each new use will imply acceptance of the latest version. The different versions will be dated and kept available at the address: <u><a href="/terms-of-use-archethic/" target="_blank"> https://www.archethic.net/terms-of-use-archethic/</a></u>. If you do not agree with the changes made to this Agreement, you must immediately cease accessing and using all our services.
              </p>
              <br />
              <p><strong>5.2 Changes to Our Services</strong><br />
                As an autonomous decentralized network (DAN), the services and interfaces made available may be modified (a) with or without notice, to modify, substitute, remove, or add to any of the services; (b) to review, modify, filter, disable, delete, and remove any content and information from any of the services.
              </p>


            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div >
  )
}
