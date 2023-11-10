'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function PrivacyPolicyBridge() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Privacy Policy for the Archethic Bridge Application
          </T>

          <T as='h2' size='headline-medium'>
            Last Updated: November 10, 2023
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <p><u><a href="https://github.com/archethic-foundation/bridge" target="_blank">Source code</a></u><br /><br /></p>

              <p>Archethic Bridge respects your privacy. We created this Privacy Policy to explain the types of information we may collect through the Archethic Bridge application (the “App”),
                how we will use, disclose and protect this information once it is collected, and how you can opt in or opt out of some of our uses and disclosures of certain information relating to your use of the App.
                <br /><br />
                Please read this Privacy Policy carefully to understand our policies and practices regarding information that we collect through the App about you and your use of the App and how we will treat it.
                If you do not agree with these policies and practices, do not download or use the App.</p>
              <br />
              <p><strong>Changes to This Privacy Policy</strong></p>

              <p>We may update this Privacy Policy from time to time, in which case we will post the updated Privacy Policy at <u><a href="/privacy-policy-wallet">https://www.archethic.net/privacy-policy-wallet.</a></u>
                The date on which this Privacy Policy has most recently been updated is indicated at the end of this Privacy Policy. In some cases, we may also tell you about changes by additional means, such as by informing you through an alert on the App.
                Your continued use of the App after we make changes will be deemed to be your acceptance of those changes, so please check the Privacy Policy periodically for updates.</p>
              <br />
              <p><strong>What This Privacy Policy Applies To</strong></p>

              <p>This Privacy Policy applies only to the App and information that we collect through the App. This Privacy Policy DOES NOT, for example, apply to information that:
                <br /><br />
                You provide to, or is collected by, any third party.
                <br />Our other apps and websites, and third parties, may have their own privacy policies, which we encourage you to read before using or providing information on, through or to them.
                For example, when you use the App on your device, certain third parties, such as your mobile device manufacturer, your mobile service provider or the services you connect to may, separate from us, use automatic information collection technologies to collect information about you or your device, and that information they collect is not covered by this Privacy Policy.
                We do not control these third parties’ data collection or tracking technologies or how they may be used.</p>
              <br />
              <p><strong>Children Under the Age of 13</strong></p>

              <p>The App is not intended for children under 13 years of age, and we do not knowingly collect personal information from children under 13.
                If we learn we have collected or received personal information from a child under 13 without verification of parental consent, we will delete that information.
                If you believe we might have any information from or about a child under 13, please contact us at <u><a href="mailto:dpo@archethic.net">dpo@archethic.net</a></u></p>
              <br />
              <p><strong>Information We Collect and How We Collect It</strong></p>

              <p>We may collect information from and about users of the App:<br /><br />Directly from you when you provide it to us in connection with the App<br />
                No personal information is required by us to use the app.<br />All private information you enter in the application (token public information, blockchain public information) are stored on your local device only and not transmitted to anyone.
                <br /><br />
                Automatically when you use the App.<br />When you use the App, we do not collect any type of personal information.<br />However, some information may be transmitted to third parties or become public for the need of proper service operation.
                <br /><br />
                IP Address and Archethic Address.<br />When the application connects to a server in order to fetch required ledger information, the server has access to your public ip address as well as your query. This information is necessary for the legitimate interest of providing the service.
                This does not leak more information than when you query your balance on the web explorer. We do not control all of the servers you can connect to. Depending on the server, logs can be kept or not, for a variable period of time. You have the possibility to run a custom server you host yourself if you want to avoid any information being transmitted to third party.
                If we process your information based on our legitimate interests as explained above, you may have the right under certain laws and regulations to object to such processing and may contact us to inform us of your objection via email at <u><a href="mailto:dpo@archethic.net">dpo@archethic.net</a></u>
                <br /><br />
                Your transaction history is immutably recorded in the Archethic Public Blockchain.<br />This transaction history is a feature of the Archethic network. No personal information is collected nor stored on the network. Only Archethic addresses and their transaction data are recorded, with no relationship to any personal information being added by Archethic itself.
                By construction, there is no possible way to remove a transaction once it has been included as part of the blockchain.</p>
              <br />
              <p><strong>Clarifications Regarding Certain Information We Do Not Collect or See</strong></p>
              <p>Any tokens that you choose to bridge using the App, and any balance or transaction information relating to it, are never held, stored, known, managed, received, sent or transmitted by us.
                You are solely responsible for the security and privacy of your own Archethic currency and information relating to it.<br /><br />We do not track the location of your device through the App.<br /><br />We do not collect your name or contact information through the App.</p>
              <br />
              <p><strong>Logs for Analyzing Anomalies</strong></p>

              <p>In addition to the information mentioned above, we collect logs, both functional and technical, to analyze anomalies in the Apps operation. These logs may contain information related to the transactions performed but do not in any way allow us to alter or interfere with the transactions. These logs do not contain sensitive information such as seed or private keys.</p>
              <br />
              <p><strong>How We Use Your Information</strong></p>

              <p>We use the information that we collect about you through the App to:<br /><br />- Provide you with, operate and maintain the App and its contents, and any other information, products or services that you request from us;
                <br />
                - Fulfill any other purpose for which you provide it;</p>
              <br />
              <p><strong>Disclosure of Your Information</strong></p>

              <p>Notwithstanding anything to the contrary in this Privacy Policy, we may disclose aggregated anonymous information about our users, and information that does not identify any individual or device or account, to others, for their own use, without restriction.
                <br /><br />
                In addition, we may disclose information (including, without limitation, personal information) that we collect or you provide to us:
                <br /><br />
                - To fulfill the purpose(s) for which you provide it;
                <br />
                - For any other purpose disclosed by us when you provide the information;
                <br />
                - With your consent;
                <br />
                - To comply with any court order, law or legal process, including to respond to any government or regulatory request;</p>
              <br />
              <p><strong>Data Security</strong></p>

              <p>We have implemented measures designed to secure your personal information from accidental loss and from unauthorized access, use, alteration and disclosure. Unfortunately, the transmission of information via the internet and mobile platforms is not completely secure.
                While we endeavor to protect your personal information, we cannot guarantee the security of your personal information transmitted or collected through the App. Any transmission of personal information is at your own risk. We are not responsible for circumvention of any privacy settings or security measures we provide and will not have any liability for disclosure of your personal information due to errors or unauthorized acts of third parties during or after transmission or collection.
                <br /><br />
              </p>
              <br />

              <p><strong>Responsibility for EVM Wallets</strong></p>

              <p>It is important to note that Archethic assumes no responsibility for the EVM (Ethereum Virtual Machine) wallets that users choose to utilize in conjunction with the Archethic Bridge application. These EVM wallets are separate and independent entities, subject to their own privacy policies and terms of use. Archethic cannot control the data collection, use, or protection practices of these wallets.
                <br /><br />We strongly encourage our users to carefully review the privacy policies associated with the EVM wallets they use. Each EVM wallet may have specific rules and procedures regarding the handling of user data. It is the responsibility of each user to become familiar with these policies and understand how their data is processed by EVM wallets.
                <br /><br />Archethic places a strong emphasis on protecting the privacy of its users within the Archethic Bridge application. However, this protection does not extend to third-party EVM wallets. Therefore, we recommend that our users take appropriate measures to safeguard their information when using third-party EVM wallets and adhere to the privacy policies and terms of use of these services.</p>
              <br />
              <p><strong>Contact Information</strong></p>

              <p>Please let me know if you have any questions or concerns about this policy by contacting me at the following mail address: <u><a href="mailto:dpo@archethic.net">dpo@archethic.net</a></u><br /><br />This policy is effective November 10, 2023</p>

            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div >
  )
}
