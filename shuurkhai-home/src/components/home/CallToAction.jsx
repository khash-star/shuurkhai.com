import React from 'react';
import { motion } from 'framer-motion';
import { Button } from "@/components/ui/button";
import { ArrowRight, Sparkles, Phone, Mail, MessageCircle } from 'lucide-react';

export default function CallToAction() {
  return (
    <section className="py-20 bg-gradient-to-br from-slate-100 via-slate-50 to-slate-100 relative overflow-hidden">
      {/* Background Orbs */}
      <div className="absolute top-10 left-20 w-[600px] h-[600px] bg-blue-300/20 rounded-full blur-3xl" />
      <div className="absolute bottom-10 right-20 w-[600px] h-[600px] bg-purple-300/20 rounded-full blur-3xl" />

      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="bg-white/40 backdrop-blur-2xl rounded-[2.5rem] p-8 sm:p-12 border border-white/60 shadow-2xl relative overflow-hidden"
        >
          {/* Glass reflection */}
          <div className="absolute inset-0 rounded-[2.5rem] bg-gradient-to-br from-white/60 via-white/20 to-transparent pointer-events-none" />
          
          <div className="relative text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-sm border border-white/80 text-slate-700 text-sm font-semibold mb-6 shadow-sm"
            >
              <Sparkles className="w-4 h-4 text-emerald-500" />
              Одоо эхлээрэй
            </motion.div>

            <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">
              Америк барааг хурдан,
              <span className="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                найдвартай хүргүүлэх
              </span>
            </h2>
            
            <p className="text-base sm:text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
              Таны хүссэн бүх барааг агаар болон далайн каргоор Монголд хүргэнэ
            </p>

            {/* CTA Buttons */}
            <div className="flex flex-col sm:flex-row gap-3 justify-center mb-10">
              <motion.div whileHover={{ scale: 1.03 }} whileTap={{ scale: 0.98 }}>
                <Button 
                  size="lg"
                  className="bg-gradient-to-r from-slate-900 to-slate-700 text-white hover:from-slate-800 hover:to-slate-600 px-8 py-6 text-base rounded-2xl shadow-lg group"
                >
                  Бараа захиалах
                  <ArrowRight className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
                </Button>
              </motion.div>
              <motion.div whileHover={{ scale: 1.03 }} whileTap={{ scale: 0.98 }}>
                <Button 
                  size="lg"
                  variant="outline"
                  className="border-2 border-slate-300 text-slate-700 bg-white/50 backdrop-blur-sm hover:bg-white/70 px-8 py-6 text-base rounded-2xl shadow-md"
                >
                  Холбогдох
                </Button>
              </motion.div>
            </div>

            {/* Contact Info */}
            <div className="flex flex-col sm:flex-row items-center justify-center gap-6 text-slate-700">
              <a href="tel:72026471" className="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div className="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                  <Phone className="w-5 h-5 text-slate-700" />
                </div>
                <div className="text-left">
                  <p className="text-xs text-slate-500">Утас</p>
                  <p className="font-bold text-sm">72026471</p>
                </div>
              </a>
              
              <a href="viber://chat?number=99086471" className="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div className="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                  <MessageCircle className="w-5 h-5 text-slate-700" />
                </div>
                <div className="text-left">
                  <p className="text-xs text-slate-500">Viber</p>
                  <p className="font-bold text-sm">99086471</p>
                </div>
              </a>
              
              <a href="mailto:info@shuurkhai.com" className="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div className="w-11 h-11 rounded-xl bg-white/60 backdrop-blur-sm flex items-center justify-center border border-white/80 shadow-sm">
                  <Mail className="w-5 h-5 text-slate-700" />
                </div>
                <div className="text-left">
                  <p className="text-xs text-slate-500">Имэйл</p>
                  <p className="font-bold text-sm">info@shuurkhai.com</p>
                </div>
              </a>
            </div>
          </div>
        </motion.div>
      </div>
    </section>
  );
}