import React from 'react';
import Navbar from '@/components/home/Navbar';
import StorePartners from '@/components/home/StorePartners';
import HowItWorks from '@/components/home/HowItWorks';
import Benefits from '@/components/home/Benefits';
import CallToAction from '@/components/home/CallToAction';
import Footer from '@/components/home/Footer';

export default function Home() {
  return (
    <div className="min-h-screen bg-white">
      <Navbar />
      <StorePartners />
      <HowItWorks />
      <Benefits />
      <CallToAction />
      <Footer />
    </div>
  );
}