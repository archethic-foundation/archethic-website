import React from 'react'
import Flex from '@/ui/Flex/Flex'
import { T } from '@/ui/Text/Text'

function Icon({ rotation }: { rotation: number }) {
  return (
    <svg
      width='44'
      height='44'
      viewBox='0 0 44 44'
      fill='none'
      xmlns='http://www.w3.org/2000/svg'
      style={{ rotate: `${rotation}deg` }}
    >
      <g clipPath='url(#clip0_808_2076)'>
        <path
          d='M11.2383 39.2309L33.3412 39.2696C34.2137 39.2696 35.0474 38.9206 35.6678 38.3002L38.7215 35.2465C39.3419 34.6261 39.6909 33.7924 39.6909 32.9199L39.6812 29.5754C39.6812 28.4896 38.6439 27.7044 37.597 27.9952L10.3077 35.5083C9.09589 35.8476 8.68873 37.3599 9.5806 38.2517L10.075 38.7462C10.3852 39.0564 10.8021 39.2212 11.2383 39.2309Z'
          fill='white'
        />
        <path
          d='M4.57736 10.5075L4.61614 32.6104C4.61614 33.0369 4.79063 33.4635 5.09115 33.764L5.58556 34.2584C6.47743 35.1503 7.99943 34.7528 8.32903 33.5313L15.8421 6.24205C16.1329 5.19508 15.338 4.16749 14.2619 4.15779L10.9174 4.1481C10.0449 4.1481 9.21121 4.49709 8.59077 5.11752L5.53709 8.17121C4.91666 8.79164 4.56767 9.62535 4.56767 10.4978L4.57736 10.5075Z'
          fill='white'
        />
        <path
          d='M39.6607 18.3675C39.6607 17.495 39.3117 16.6613 38.701 16.0506L27.8047 5.15427C27.1939 4.54354 26.3602 4.19454 25.4878 4.19454L20.4177 4.18485C18.9538 4.17515 18.2171 5.95889 19.2544 6.99618L36.8591 24.6009C37.8964 25.6382 39.6607 24.9014 39.6704 23.4376L39.6607 18.3675Z'
          fill='white'
        />
        <path d='M39.6813 27.4232L39.6719 27.4138L39.6719 27.4326L39.6813 27.4232Z' fill='white' />
      </g>
      <defs>
        <clipPath id='clip0_808_2076'>
          <rect width='44' height='44' fill='white' />
        </clipPath>
      </defs>
    </svg>
  )
}

export default function BridgeListItem({
  text,
  iconRotation,
}: {
  text: string
  iconRotation: number
}) {
  return (
    <Flex direction='row' gap={24} smGap={16}>
      <div>
        <Icon rotation={iconRotation} />
      </div>
      <div>
        <T size='headline-medium' textWrap={false}>
          {text}
        </T>
      </div>
    </Flex>
  )
}
