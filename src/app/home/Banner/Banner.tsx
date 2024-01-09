import React from 'react';
import './Banner.scss';
import Link from 'next/link'
import { InternalLinks } from '@/config'
interface BannerProps {
    className?: string;
}

const Banner: React.FC<BannerProps> = ({ className }) => {
    return (
        <div className={`banner ${className}`}>
            <Link href={InternalLinks.CES} prefetch={false}>
                Archethic participates to CES Vegas 2024 - JANUARY 9 - 12 | Join us at the Web3 Tokenization FinTech Village Pavilion #56039.
            </Link>
        </div>
    );
};

export default Banner;
