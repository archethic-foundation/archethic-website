'use client'

import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { MaxWidthLayoutContainer } from '@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer'
import { T } from '@/ui/Text/Text'

import styles from './page.module.scss'

export default function PrivacyPolicyArchethic() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as='h2' size='display-large' weight='semibold'>
            Privacy Policy of Services Available Through the Archethic Public Blockchain
          </T>

          <T as='h2' size='headline-medium'>
            Last modification: May 12, 2024
          </T>

          <div>
            <T as='div' size='headline-medium-small'>
              <p>The Archethic Public Blockchain is a universally autonomous intangible common good, consisting of a network of decentralized and autonomous computers (Decentralized Autonomous Network, DAN) and a DAO (Decentralized Autonomous Organization) composed of individuals (developers, users) who guide and co-validate with the DAN all changes made to the DAN.</p>
              <br />
              <p>USAGE OF THE ARCHETHIC BLOCKCHAIN, DEFI SERVICES, AND GENERALLY ALL SERVICES HOSTED BY THE ARCHETHIC BLOCKCHAIN ARE PROVIDED &quot;AS IS&quot;, AT YOUR OWN RISK, AND WITHOUT WARRANTIES OF ANY KIND.</p>
              <br />
              <p><strong>Data We Collect</strong><br />
                Privacy is at the heart of everything we do with the Archethic Blockchain, and transparency is among its values. Consequently, we strive to be transparent about the minimal data we collect. We do not manage user accounts and do not collect or store personal data such as your name or Internet Protocol (IP) address. When you interact with the Services, we only collect:</p>
              <br />
              <p><strong>Publicly Accessible Blockchain Data: </strong>Before using a public blockchain, be aware that all your transactions will be publicly accessible. The principle of Blockchains is to prove the existence of your holdings through the history of your previous public transactions. Thus, while no public data allows for personal identification (pseudonymity), anyone you exchange assets with will have public access to your history. You can, however, create as many Wallets as necessary to avoid any cross-referencing.</p>
              <br />
              <p><strong>Local Information and Other Tracking Technologies: </strong>Most services use cookies, beacons, and other similar technologies to provide personalized navigation and optimize service performance, none of these data is retrieved or processed individually. Information collected (logs, etc.) from these technologies may include details such as browser type, referring/exiting pages, operating system, device or browser language, and other device information. These collective data may be processed to improve the user experience of the products.</p>
              <br />
              <p><strong>Case of Services Requiring Centralization</strong><br />
                For services that necessarily require centralization (non-limiting examples: Wallet, Stores, cloud hosting, etc.) and therefore depend on the privacy policies of various providers (Apple App Store, Google Play, Microsoft Store for example), data remains collected according to your instructions, but as required by law, these data may be used for the following purposes:</p>
              <ul style={{ paddingLeft: '40px' }}>
                <li><strong>Service Provision: </strong>To maintain, personalize, and improve the Services.</li>
                <li><strong>Customer Service: </strong>To provide support and respond to inquiries about the Services.</li>
                <li><strong>Safety and Security: </strong>To protect, investigate, and deter fraudulent, unauthorized, or illegal activities or to manage security risks, solve potential security issues such as bugs, enforce our agreements, and protect our users and associated companies.</li>
                <li><strong>Legal Compliance: </strong>To comply with applicable laws and regulations at the request of regulators, government entities, and law enforcement, as well as in litigation, regulatory proceedings, compliance measures, and when compelled by a court order or any other judicial proceeding.</li>
              </ul>
              <br />
              <p><strong>Web Traffic Analysis with Plausible Analytics</strong><br />
                We use Plausible Analytics to analyze the use of the Service with the goal of improving our services and user experience. Plausible is a privacy-respecting analytics tool, designed with an ethical approach that emphasizes non-intrusion and respect for user data.</p>
              <ul style={{ paddingLeft: '40px' }}>
                <li><strong>Data Collection: </strong>Unlike other analytics tools, Plausible does not collect any personally identifiable information and does not use cookies. This means your navigation on our site remains anonymous. The collected information includes general metrics such as the number of visitors, most visited pages, the country of origin of the visitors, etc., without ever individually identifying visitors.</li>
                <li><strong>Data Use: </strong>Data collected by Plausible is used to understand usage trends of our site, which helps us improve our content and optimize the user experience. This information is only used for the analysis of our site traffic and is not shared with third parties.</li>
                <li><strong>Privacy Respect: </strong>By choosing Plausible as an analytics tool, we commit to respecting the privacy of our visitors. Plausible is designed to comply with the General Data Protection Regulation (GDPR) of the European Union, the California Consumer Privacy Act (CCPA), and other privacy regulations.</li>
              </ul>
              <br />
              <p>For more information on Plausible Analytics privacy policy and how they process data, you can visit their website at <u><a href="https://plausible.io/" target="_blank">https://plausible.io/</a></u></p>
              <br />
              <p><strong>Security</strong><br />
                We implement and maintain reasonable administrative, physical, and technical security measures to help protect data against loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction. However, transmission via the Internet is not entirely secure, and we cannot guarantee the security of your information. You are responsible for all your activities on the Services, including the security of your blockchain network addresses, your cryptocurrency wallets, and their cryptographic keys.</p>
              <br />
              <p><strong>Age Conditions</strong><br />
                To access or use any of the services provided by the Archethic Public Blockchain, you must comply with the applicable regulations of your jurisdiction. Consequently, you declare that you are at least the age of majority in your jurisdiction (for example, 18 years old) and that you have all the rights, powers, and authority to enter into and comply with the terms and conditions of this Agreement on your behalf and on behalf of any company or legal entity for which you may access or use the Interface.</p>
              <br />
              <p><strong>Disclosures for Data Subjects within the European Union</strong><br />
                We process personal data for the purposes described in this document. Our bases for processing your data include: (i) you have given your consent to the processing or to our service provided for one or more specific purposes; (ii) the processing is necessary for the performance of a contract with you; (iii) the processing is necessary for compliance with a legal obligation; and/or (iv) the processing is necessary for the purposes of the legitimate interests pursued by us or by a third party, and your interests and fundamental rights and freedoms do not override those interests.
                Your rights under the General Data Protection Regulation (&quot;GDPR&quot;) include the right to (i) request access and obtain a copy of your personal data, (ii) request rectification or erasure of your personal data, (iii) object to or restrict the processing of your personal data; and (iv) request the portability of your personal data. Furthermore, you can withdraw your consent to our collection at any time.
              </p>

              <p>However, we cannot modify or delete information stored on a particular blockchain. Information such as your transaction data, blockchain wallet address, and assets held by your address that may be linked to the data we collect are beyond our control.
                To exercise any of your rights under the GDPR, please contact us at dpo@archethic.net.
                We may ask you for additional information to process your request. Please note that we may retain information to the extent necessary to achieve the purpose for which it was collected and continue to do so even after a request from the concerned individual in accordance with our legitimate interests, including to comply with our legal obligations, resolve disputes, prevent fraud, and enforce our agreements.
              </p>
              <br />
              <p><strong>Changes to This Policy</strong><br />
                If we make significant changes to this policy, we will notify you through the services. Nevertheless, your continued use of the Services reflects your periodic review of this Policy and other company terms and conditions and indicates your consent to them. If you disagree with changes to this Agreement, you must immediately cease accessing and using the Services.</p>
              <br />
              <p><strong>Contact Us</strong><br />
                If you have any questions about this policy or how we collect, use, or share your information, please contact us at <u><a href="mailto:dpo@archethic.net">dpo@archethic.net</a></u>.</p>
            </T>
          </div>
        </Flex>
      </MaxWidthLayoutContainer>
    </div >
  )
}
