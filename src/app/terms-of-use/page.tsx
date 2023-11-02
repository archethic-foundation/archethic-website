'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function TermsUse() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Terms of Use
          </T>

          <T as='h2' size='headline-medium'>
            Last updated: September 19, 2023
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <p>
                These Terms of Use apply to www.archethic.net as well as any other affiliated sites,
                digital services, or applications on which a link to these Terms of Use appears
                (collectively, the {`"`}Website{`"`}) and apply to all visitors. These Terms of Use
                and any other terms that appear on the page from which you were directed to these
                Terms of Use govern your use of the Website. By accessing the Website, you agree to
                be legally bound by the Terms of Use then in effect. Please also refer to the
                relevant additional legal information applicable to your country. These Terms of Use
                as well as the information and materials contained in the Website are subject to
                change at any time and from time to time, without notice. If you do not agree to be
                bound by these Terms of Use, do not use the Website. The Website and all information
                and functionalities contained within them are not directed at or intended for use by
                any person resident or located in any jurisdiction where (1) the distribution of
                such information or functionality is contrary to the laws of such jurisdiction; or
                (2) such distribution is prohibited without obtaining the necessary licenses or
                authorizations by the relevant branch, subsidiary or affiliate office of Foundation
                and such licenses or authorizations have not been obtained.
              </p>

              <p>
                Unless specifically stated otherwise, all price information is indicative only. No
                representation or warranty, either express or implied, is provided in relation to
                the accuracy, completeness or reliability of the materials, nor are they a complete
                statement of the securities, markets or developments referred to herein. The
                materials should not be regarded by recipients as a substitute for the exercise of
                their own judgment. All information and materials published, distributed or
                otherwise made available on the Website are provided for informational purposes, for
                your non-commercial, personal use only. No information or materials published on the
                Website constitutes a solicitation, an offer, or a recommendation to buy or sell any
                investment instruments, to effect any transactions, or to conclude any legal act of
                any kind whatsoever. Foundation does not provide investment, legal or tax advice
                through the Website and nothing herein should be construed as being financial,
                legal, tax or other advice.
              </p>

              <p>
                Your use of the Website is at your own risk. The Website, together with all content,
                information and materials contained therein, is provided {`"`}as is{`"`} and {`"`}as
                available{`"`}, without any representations or warranties of any kind. Any
                materials, information or content accessed, downloaded or otherwise obtained through
                the use of the Website is done at your own risk and Foundation is not responsible
                for any damage to your computer systems or loss of data that results from the
                download of such material. To the fullest extent permitted by law, in no event shall
                Foundation or our affiliates, or any of our directors, employees, contractors,
                service providers or agents have any liability whatsoever to any person for any
                direct or indirect loss, liability, cost, claim, expense or damage of any kind,
                whether in contract or in tort, including negligence, or otherwise, arising out of
                or related to the use of all or part of the Website, or any links to third party
                websites. Foundation shall not be liable to you or anybody else for any damages
                incurred in connection with any messages sent to Foundation using ordinary E-mail or
                any other electronic messaging system.
              </p>

              <p>
                Nothing in this website is an offer to sell, or the solicitation of an offer to buy,
                any tokens. Archethic is publishing this website solely to receive feedback and
                comments from the public. If and when Archethic offers for sale any tokens (or a
                Simple Agreement for Future Tokens), it will do so through definitive offering
                documents, including a disclosure document and risk factors. Those definitive
                documents also are expected to include an updated version of this website, which may
                differ significantly from the current version. If and when Archethic makes such an
                offering in the United States, the offering likely will be available solely to
                accredited investors. Nothing in this website should be treated or read as a
                guarantee or promise of how Archethic’s business or the tokens will develop or of
                the utility or value of the tokens. This website outlines current plans, which could
                change at its discretion, and the success of which will depend on many factors
                outside Archethic’s control, including market-based factors and factors within the
                data and cryptocurrency industries, among others. Any statements about future events
                are based solely on Archethic’s analysis of the issues described in this website.
                That analysis may prove to be incorrect.
              </p>
            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div>
  )
}
