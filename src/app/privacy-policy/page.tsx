'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function PrivacyPolicy() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Privacy Policy for the Archethic Website
          </T>

          <T as='h2' size='headline-medium'>
            Last Updated: September 25, 2023
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <p>
                At Archethic, we value the privacy of our visitors. This privacy policy outlines how
                we handle information when you visit our website, www.archethic.net, hereafter
                referred to as {'"'}the Site.{'"'}
              </p>
              <br />
              <p>
                <strong>No Collection of Personal Information</strong>
              </p>

              <p>
                We do not collect any personal information from visitors to the Site. We do not use
                cookies or tracking technologies to gather information about your browsing.
              </p>
              <br />

              <p>
                <strong>No Use of Personal Information</strong>
              </p>

              <p>
                Since we do not collect personal information, we have no use for such information to
                disclose.
              </p>
              <br />

              <p>
                <strong>Links to Other Websites</strong>
              </p>

              <p>
                The Site may contain links to third-party websites. We are not responsible for the
                privacy practices or content of these websites. We encourage you to review the
                privacy policies of these sites before providing any personal information.
              </p>
              <br />

              <p>
                <strong>Changes to the Privacy Policy</strong>
              </p>

              <p>
                We reserve the right to modify this privacy policy at any time. Any changes will be
                posted on this page, and the date of the last update will be adjusted accordingly.
              </p>
              <br />

              <p>
                <strong>Contact Us</strong>
              </p>

              <p>
                If you have any questions regarding this privacy policy, you can contact us at the
                following email address: contact@archethic.net.
              </p>
            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div>
  )
}
