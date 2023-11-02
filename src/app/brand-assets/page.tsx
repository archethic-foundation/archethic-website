"use client";

import React from "react";
import Flex from "@/ui/Flex/Flex";
import { MaxWidthLayoutContainer } from "@/ui/MaxWidthLayoutContainer/MaxWidthLayoutContainer";
import { T } from "@/ui/Text/Text";

import styles from "./page.module.scss";

export default function BrandAssets() {
  return (
    <div className={styles.container}>
      <MaxWidthLayoutContainer>
        <Flex gap={32} smGap={16}>
          <T as="h2" size="display-large" weight="semibold">
            Brand <u>Assets</u>
          </T>
          <T as="h2" size="headline-medium">
            Welcome to Archethic Brand Assets, Press & Media page
          </T>
          <T size="headline-medium">
            <u>Logos, colors, typography, type scale and assets</u>
          </T>

          <T as="div" size="headline-medium-small">
            <h3>Repository</h3>
            <ul>
              <li>
                Find the official Archethic assets repository{" "}
                <a
                  target="_blank"
                  href="https://github.com/archethic-foundation/archethic-assets"
                >
                  <u>here...</u>
                </a>
              </li>
            </ul>
          </T>

          <T size="headline-medium">
            <u>Brand Voice</u>
          </T>

          <T as="div" size="headline-medium-small">
            <h3>Tone</h3>
            <ul>
              <li>Simple, easy to understand vocabulary</li>
              <li>Transparent state of communication</li>
              <li>Confident Claims and Data Points</li>
              <li>
                Keep Balance of use cases + announcements + features while
                communicating
              </li>
            </ul>
            <br />
            <h3>Best Practices:</h3>
            <ul>
              <li>
                <h4>Archethic</h4>
                <ul>
                  <li>Use Archethic (as written) across all communication</li>
                  <li>Incorrect usage:</li>
                  <ul>
                    <li>ARCHEthic</li>
                    <li>ArchEthic</li>
                    <li>ARCHETHIC</li>
                  </ul>
                </ul>
              </li>
            </ul>
            <br />
            <ul>
              <li>
                <h4>Uniris, Archethic Blockchain and Archethic Foundation</h4>
                <ul>
                  <li>
                    Uniris is a private blockchain software company that
                    develops decentralized software services and applications
                    that operate on the Archethic Public Blockchain.
                  </li>
                  <li>
                    Archethic Public Blockchain is the first integrated services
                    platform capable of meeting a fundamental need: giving
                    everyone back the control over technology. In this way,
                    Archethic is part of the promise of a safer, more inclusive,
                    and truly decentralised world.
                    <ul>
                      <li>
                        Correct usage: Archethic Public Blockchain , Archethic
                        Blockchain
                      </li>
                    </ul>
                  </li>
                  <li>
                    Archethic Foundation is a non-profit foundation whose vision
                    is the promotion of the Archethic Public Blockchain
                    Protocol. It considers Archethic as a project – where a
                    solid technical foundation is a key to winning the marathon
                    race to global adoption. Its role is to sustainably deploy
                    resources that are under control to support the long-term
                    success of Archethic.
                  </li>
                </ul>
              </li>
            </ul>
            <br />
            <ul>
              <li>
                <h4>ARCH Consensus</h4>
                <ul>
                  <li>
                    How it works:
                    <br />
                    Consider a village of 100,000 people where every person in
                    the village keeps the entire payments records of all the
                    people in the village. Alice and Bob are citizens of the
                    village.
                    <br />
                    <ul>
                      <li>
                        Traditional Consensus: When Alice sends Bob 10 units (of
                        some currency) you normally expect all the 100,000
                        people to approve this transaction, this takes a lot of
                        time and the village will not be able to process a lot
                        of these transactions.
                      </li>
                    </ul>
                    <ul>
                      <li>
                        ARCH Consensus: When Alice sends Bob 10 units (of some
                        currency), the transaction is validated by randomly
                        selecting 200 people out of 100,000 people, where all
                        the 200 selected will have the same answer. This akes
                        very less time to validate and the village is able to
                        process any number of transactions.
                      </li>
                    </ul>
                    <ul>
                      <li>
                        Correct usage:
                        <ul>
                          <li>
                            “ARCH consensus” for english language communications
                          </li>
                          <li>
                            “consensus ARCHE” for french language communications
                          </li>
                        </ul>
                      </li>
                    </ul>
                    <ul>
                      <li>
                        Incorrect usage:
                        <ul>
                          <li>arche</li>
                          <li>arch</li>
                          <br />
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li>
                <h4>UCO</h4>
                <ul>
                  UCO is the cryptocurrency that runs the Archethic Public
                  Blockchain.
                </ul>
              </li>
            </ul>
          </T>

          <T as="h3" size="headline-medium">
            <u>Brand Story</u>
          </T>

          <T as="div" size="headline-medium-small">
            Our team is a unique blend of complementary, cohesive, and
            experienced personalities from companies such as Thales, Mastercard,
            Barclays, Orange, Mozilla, Google, PwC, and researchers from the
            École Polytechnique and CNRS.
            <br />
            <br />
            Uniris Company was created in 2017, Sebastien is intrigued by the
            idea of blockchain and its benefits. The design of the blockchain is
            elegant, driven by mathematics and without contradiction. Such
            code-mathematical control would create a concept of equality, free
            of prejudice and bias.
            <br />
            <br />
            After 4 years of rigorous research by Sebastien, Nilesh and
            Christophe have resulted in 11 patents and an ecosystem ready for
            mass use. In 2020 the official launch of Archethic Public Blockchain
            took place, a blockchain that could provide scalability, be 100%
            secure and sustainable along with added benefits of a biometric
            solution that simplifies access and management of private keys. In
            other words, a future-proof blockchain.
            <br />
            <br />
            The original idea was to apply this concept to create a P2P
            decentralized marketplace. The team started looking at possible base
            layers available at the time, such as Ethereum and Bitcoin
            blockchain but quickly realized that they had a common drawback:
            they were not scalable and inaccessible. The team feels the
            blockchain ecosystem is so esoteric that its adoption is limited to
            the tech-savvy nerd segment. This observation became evident when
            Sebastien, CEO of Uniris, tried explaining the concept to his
            grandmother, who was unable to fathom the whole private key
            management aspect. It led to the realization that adoption would
            only be possible through the simplicity of use, and if adoption was
            successful, then scalability to manage the growth was of utmost
            importance.
            <br />
            <br />
            In simple words, our decision to create the Archethic Blockchain was
            to innovate every layer. In other words, a Grandma Proof Blockchain
            that is ready for world adoption.
          </T>
        </Flex>
      </MaxWidthLayoutContainer>
    </div>
  );
}
