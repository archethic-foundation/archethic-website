import React from 'react';
import './Banner.scss';

interface BannerProps {
    className?: string;
}

const Banner: React.FC<BannerProps> = ({ className }) => {
    return (
        <div className={`banner ${className}`}>
            Archethic will participate in CES Vegas 2024 - JANUARY 9 - 12 | Join us at the Web3 Tokenization FinTech Village Pavilion #56039.
        </div>
    );
};

export default Banner;
