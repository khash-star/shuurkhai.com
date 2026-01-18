import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Button } from "@/components/ui/button";
import { Plane, Ship, Menu, X, ChevronDown, Package, Calculator, Phone } from 'lucide-react';
import { Link } from 'react-router-dom';
import { createPageUrl } from '@/utils';

const navLinks = [
  { name: 'Нүүр', href: '#' },
  { 
    name: 'Үйлчилгээ', 
    href: '#',
    submenu: [
      { name: 'Агаарын карго', icon: Plane, href: '#' },
      { name: 'Далайн карго', icon: Ship, href: '#' },
      { name: 'Онлайн захиалга', icon: Package, href: '#' },
      { name: 'Үнийн тооцоолуур', icon: Calculator, href: createPageUrl('Calculator') },
    ]
  },
  { name: 'Үнийн мэдээлэл', href: '#' },
  { name: 'Холбоо барих', href: '#' },
];

export default function Navbar() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [activeSubmenu, setActiveSubmenu] = useState(null);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <>
      <motion.nav
        initial={{ y: -100 }}
        animate={{ y: 0 }}
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
          isScrolled 
            ? 'bg-white/80 backdrop-blur-xl shadow-lg shadow-slate-200/50' 
            : 'bg-transparent'
        }`}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-20">
            {/* Logo */}
            <motion.a 
              href="#" 
              className="flex items-center gap-3"
              whileHover={{ scale: 1.02 }}
            >
              <div className="w-11 h-11 rounded-xl bg-slate-900 flex items-center justify-center shadow-sm">
                <div className="flex">
                  <Plane className="w-4 h-4 text-white -rotate-45" />
                  <Ship className="w-4 h-4 text-emerald-400 -ml-0.5" />
                </div>
              </div>
              <span className="text-xl font-bold text-slate-900">
                Shuurkhai
              </span>
            </motion.a>

            {/* Desktop Navigation */}
            <div className="hidden lg:flex items-center gap-8">
              {navLinks.map((link) => (
                <div
                  key={link.name}
                  className="relative"
                  onMouseEnter={() => link.submenu && setActiveSubmenu(link.name)}
                  onMouseLeave={() => setActiveSubmenu(null)}
                >
                  <a
                    href={link.href}
                    className={`flex items-center gap-1 font-medium transition-colors ${
                      isScrolled ? 'text-slate-700 hover:text-[#1e3a5f]' : 'text-slate-700 hover:text-[#1e3a5f]'
                    }`}
                  >
                    {link.name}
                    {link.submenu && <ChevronDown className="w-4 h-4" />}
                  </a>

                  {/* Submenu */}
                  <AnimatePresence>
                    {link.submenu && activeSubmenu === link.name && (
                      <motion.div
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: 10 }}
                        className="absolute top-full left-0 pt-4"
                      >
                        <div className="bg-white rounded-2xl shadow-xl border border-slate-100 p-2 min-w-[220px]">
                          {link.submenu.map((item) => (
                            item.href.startsWith('#') ? (
                              <a
                                key={item.name}
                                href={item.href}
                                className="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors"
                              >
                                <div className="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                  <item.icon className="w-5 h-5 text-[#1e3a5f]" />
                                </div>
                                <span className="font-medium text-slate-700">{item.name}</span>
                              </a>
                            ) : (
                              <Link
                                key={item.name}
                                to={item.href}
                                className="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors"
                              >
                                <div className="w-10 h-10 rounded-lg bg-[#1e3a5f]/5 flex items-center justify-center">
                                  <item.icon className="w-5 h-5 text-[#1e3a5f]" />
                                </div>
                                <span className="font-medium text-slate-700">{item.name}</span>
                              </Link>
                            )
                          ))}
                        </div>
                      </motion.div>
                    )}
                  </AnimatePresence>
                </div>
              ))}
            </div>

            {/* CTA Buttons */}
            <div className="hidden lg:flex items-center gap-4">
              <Link to={createPageUrl('Calculator')}>
                <Button 
                  variant="ghost"
                  className="text-slate-700 hover:bg-slate-50"
                >
                  <Calculator className="w-4 h-4 mr-2" />
                  Үнэ тооцоолох
                </Button>
              </Link>
              <Button 
                className="bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-sm"
              >
                Захиалах
              </Button>
            </div>

            {/* Mobile Menu Button */}
            <button
              className="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            >
              {isMobileMenuOpen ? (
                <X className="w-6 h-6 text-slate-900" />
              ) : (
                <Menu className="w-6 h-6 text-slate-900" />
              )}
            </button>
          </div>
        </div>
      </motion.nav>

      {/* Mobile Menu */}
      <AnimatePresence>
        {isMobileMenuOpen && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20 }}
            className="fixed inset-x-0 top-20 z-40 lg:hidden"
          >
            <div className="bg-white/95 backdrop-blur-xl border-t border-slate-100 shadow-xl">
              <div className="max-w-7xl mx-auto px-4 py-6">
                <div className="space-y-2">
                  {navLinks.map((link) => (
                    <div key={link.name}>
                      <a
                        href={link.href}
                        className="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors"
                        onClick={() => !link.submenu && setIsMobileMenuOpen(false)}
                      >
                        {link.name}
                      </a>
                      {link.submenu && (
                        <div className="ml-4 mt-1 space-y-1">
                          {link.submenu.map((item) => (
                            item.href.startsWith('#') ? (
                              <a
                                key={item.name}
                                href={item.href}
                                className="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors"
                                onClick={() => setIsMobileMenuOpen(false)}
                              >
                                <item.icon className="w-4 h-4 text-[#1e3a5f]" />
                                {item.name}
                              </a>
                            ) : (
                              <Link
                                key={item.name}
                                to={item.href}
                                className="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-50 transition-colors"
                                onClick={() => setIsMobileMenuOpen(false)}
                              >
                                <item.icon className="w-4 h-4 text-[#1e3a5f]" />
                                {item.name}
                              </Link>
                            )
                          ))}
                        </div>
                      )}
                    </div>
                  ))}
                </div>

                <div className="mt-6 pt-6 border-t border-slate-100 space-y-3">
                  <Link to={createPageUrl('Calculator')} className="block">
                    <Button 
                      variant="outline"
                      className="w-full justify-center rounded-xl"
                      onClick={() => setIsMobileMenuOpen(false)}
                    >
                      <Calculator className="w-4 h-4 mr-2" />
                      Үнэ тооцоолох
                    </Button>
                  </Link>
                  <Button 
                    className="w-full bg-gradient-to-r from-[#1e3a5f] to-[#2d5a8f] text-white rounded-xl"
                  >
                    Захиалах
                  </Button>
                </div>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}