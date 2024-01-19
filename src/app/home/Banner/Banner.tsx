import React from 'react';
import './Banner.scss';
interface BannerProps {
    className?: string;
}

const Banner: React.FC<BannerProps> = ({ className }) => {
    return (
        <div className={`banner ${className}`} />
    );
};

export default Banner;
