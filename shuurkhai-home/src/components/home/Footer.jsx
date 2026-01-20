import React from 'react';
import { motion } from 'framer-motion';
import { Facebook, Instagram, Youtube, Twitter, MapPin, Phone, Mail, ArrowUpRight } from 'lucide-react';

const footerLinks = {
  services: {
    title: 'Үйлчилгээ',
    links: [
      { name: 'Агаарын карго', href: '#' },
      { name: 'Далайн карго', href: '#' },
      { name: 'Онлайн дэлгүүр', href: '#' },
      { name: 'Үнийн мэдээлэл', href: '#' },
    ],
  },
  stores: {
    title: 'Онлайн дэлгүүрүүд',
    links: [
      { name: 'Amazon', href: '#' },
      { name: 'Walmart', href: '#' },
      { name: 'Target', href: '#' },
      { name: 'eBay', href: '#' },
    ],
  },
  company: {
    title: 'Компани',
    links: [
      { name: 'Бидний тухай', href: '#' },
      { name: 'Түгээмэл асуулт', href: '#' },
      { name: 'Холбоо барих', href: '#' },
      { name: 'Үйлчилгээний нөхцөл', href: '#' },
    ],
  },
};

const socialLinks = [
  { icon: Facebook, href: '#', label: 'Facebook' },
  { icon: Instagram, href: '#', label: 'Instagram' },
  { icon: Youtube, href: '#', label: 'Youtube' },
  { icon: Twitter, href: '#', label: 'Twitter' },
];

export default function Footer() {
  return (
    <footer className="bg-[#0f1f33] text-white relative overflow-hidden">
      {/* Background Pattern */}
      <div className="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        {/* Main Footer */}
        <div className="py-16 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 lg:gap-12">
          {/* Brand Column */}
          <div className="col-span-2 md:col-span-4 lg:col-span-1">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
            >
              {/* Logo */}
              <div className="flex items-center gap-3 mb-6">
                <img src="/images/logo.png" alt="Shuurkhai Logo" className="h-12 w-auto object-contain" />
                <span className="text-2xl font-bold">www.SHUURKHAI.com</span>
              </div>

              <p className="text-slate-400 mb-6 leading-relaxed">
                Америкийн онлайн дэлгүүрүүдээс бараа захиалж, найдвартай каргоор Монголд хүргүүлээрэй.
              </p>

              {/* Social Links */}
              <div className="flex gap-3">
                {socialLinks.map((social) => (
                  <motion.a
                    key={social.label}
                    href={social.href}
                    whileHover={{ scale: 1.1 }}
                    whileTap={{ scale: 0.95 }}
                    className="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors"
                    aria-label={social.label}
                  >
                    <social.icon className="w-5 h-5 text-slate-400" />
                  </motion.a>
                ))}
              </div>
            </motion.div>
          </div>

          {/* Link Columns */}
          {Object.entries(footerLinks).map(([key, section], index) => (
            <motion.div
              key={key}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
            >
              <h3 className="text-sm font-semibold text-white uppercase tracking-wider mb-4">
                {section.title}
              </h3>
              <ul className="space-y-3">
                {section.links.map((link) => (
                  <li key={link.name}>
                    <a
                      href={link.href}
                      className="text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1 group"
                    >
                      {link.name}
                      <ArrowUpRight className="w-3 h-3 opacity-0 -translate-y-1 translate-x-1 group-hover:opacity-100 group-hover:translate-y-0 group-hover:translate-x-0 transition-all" />
                    </a>
                  </li>
                ))}
              </ul>
            </motion.div>
          ))}

          {/* Contact Column */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: 0.3 }}
          >
            <h3 className="text-sm font-semibold text-white uppercase tracking-wider mb-4">
              Холбоо барих
            </h3>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <MapPin className="w-5 h-5 text-emerald-400 mt-0.5 flex-shrink-0" />
                <span className="text-slate-400">
                  Улаанбаатар хот, СБД, Олимпийн гудамж 12
                </span>
              </li>
              <li>
                <a href="tel:+97677001234" className="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                  <Phone className="w-5 h-5 text-emerald-400" />
                  +976 7700 1234
                </a>
              </li>
              <li>
                <a href="mailto:info@shuurkhai.com" className="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                  <Mail className="w-5 h-5 text-emerald-400" />
                  info@shuurkhai.com
                </a>
              </li>
            </ul>
          </motion.div>
        </div>

        {/* Bottom Bar */}
        <div className="py-6 border-t border-white/10">
          <div className="flex flex-col sm:flex-row justify-between items-center gap-4">
            <p className="text-sm text-slate-500">
              © {new Date().getFullYear()} www.SHUURKHAI.com. Бүх эрх хуулиар хамгаалагдсан.
            </p>
            <div className="flex items-center gap-6">
              <a href="#" className="text-sm text-slate-500 hover:text-white transition-colors">
                Нууцлалын бодлого
              </a>
              <a href="#" className="text-sm text-slate-500 hover:text-white transition-colors">
                Үйлчилгээний нөхцөл
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}