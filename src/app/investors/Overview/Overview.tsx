'use client'

import React, { useState, useEffect } from 'react'
import CardSmall from '@/ui/CardSmall/CardSmall'
import Flex from '@/ui/Flex/Flex'
import SectionPrimary from '@/ui/SectionPrimary/SectionPrimary'
import { T } from '@/ui/Text/Text'

import styles from './Overview.module.scss'

export default function Overview() {
  const [marketCap, setMarketCap] = useState('');
  const [currentPrice, setCurrentPrice] = useState(0);
  const [currentCirculatingSupply, setCurrentCirculatingSupply] = useState('');

  useEffect(() => {
    async function fetchData() {
      try {
        // Fetch data for market cap and current price
        const response1 = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=archethic&vs_currencies=usd");
        const data1 = await response1.json();
        const fetchedCurrentPrice = data1.archethic.usd;

        // Fetch data for circulating supply
        const response2 = await fetch("https://faas-fra1-afec6ce7.doserverless.co/api/v1/web/fn-22626224-17fb-4eaa-a5a6-0b487a06ac59/https/uco-circulating-supply");
        const data2 = await response2.json();
        const fetchedCirculatingSupply = data2.circulating_supply;
        const formattedCirculatingSupply = (fetchedCirculatingSupply / 1000000).toFixed(0) + "M";

        // Calculate market cap
        const calculatedMarketCap = fetchedCurrentPrice * fetchedCirculatingSupply;
        const formattedMarketCap = (calculatedMarketCap / 1000000).toFixed(2) + "M";

        // Update state with fetched data
        setCurrentPrice(fetchedCurrentPrice);
        setCurrentCirculatingSupply(formattedCirculatingSupply);
        setMarketCap(formattedMarketCap);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }

    fetchData();
  }, []);

  return (
    <SectionPrimary id='buildWithUs' backgroundImage='dottedWave' className={styles.container}>
      <Flex gap={40}>
        <Flex gap={24}>
          <T as='h5' size='label-regular'>
            Overview
          </T>
          <T as='h2' size='display-large' weight='semibold'>
            A Model designed to grow
          </T>
        </Flex>

        <Flex gap={80} smGap={16} direction='row' smDirection='column' className={styles.text}>
          <T as='p' size='headline-regular'>
            The $UCO token represents decentralized shares of Archethic blockchain.<br />It is the fuel consumed for every transaction on the network and is engineered to scale exponentially with on-chain traffic expansion.
          </T>
        </Flex>
      </Flex>
      <div className={styles.cards}>
        <CardSmall
          variant='secondary'
          counter={marketCap !== null ? `$${marketCap}` : ''}
          title='Market Cap'
          text='Current market capitalization'
        />
        <CardSmall
          variant='secondary'
          counter={currentCirculatingSupply !== null ? `${currentCirculatingSupply} UCO` : ''}
          title='Circulating Supply'
          text='Number of tokens in circulation'
        />
        <CardSmall
          variant='secondary'
          counter={currentPrice !== null ? `$${currentPrice}` : ''}
          title='Current Price'
          text='Aggregated UCO Price'
        />
        <CardSmall variant='secondary' counter='1 B' title='Total Supply' />
      </div>
    </SectionPrimary>
  )
}

