import React from 'react';
import { motion } from 'framer-motion';
import { Zap, Warehouse, Shield, MessageCircle, Award, Clock, Globe, HeartHandshake } from 'lucide-react';

const benefits = [
  {
    icon: Zap,
    title: 'Шуурхай хүргэлт',
    desc: 'Агаарын каргоор 5-10 хоногт хүргэнэ',
    gradient: 'from-yellow-500 to-orange-500',
  },
  {
    icon: Warehouse,
    title: 'АНУ дахь агуулах',
    desc: 'Орегон, Калифорнид агуулахтай',
    gradient: 'from-blue-500 to-indigo-600',
  },
  {
    icon: Shield,
    title: 'Найдвартай карго',
    desc: '100% даатгалтай, найдвартай',
    gradient: 'from-green-500 to-emerald-600',
  },
  {
    icon: MessageCircle,
    title: 'Монгол дэмжлэг',
    desc: '24/7 Монгол хэлээр үйлчилнэ',
    gradient: 'from-purple-500 to-violet-600',
  },
];

const additionalBenefits = [
  { icon: Award, text: '10+ жилийн туршлага' },
  { icon: Clock, text: 'Бодит цагийн tracking' },
  { icon: Globe, text: 'Дэлхийн түвшний үйлчилгээ' },
  { icon: HeartHandshake, text: 'Үнэнч хэрэглэгчдийн хөнгөлөлт' },
];

export default function Benefits() {
  return (
    <section className="py-20 bg-gradient-to-b from-slate-50 via-slate-100 to-slate-50 relative overflow-hidden">
      {/* Background Elements */}
      <div className="absolute top-20 right-10 w-[500px] h-[500px] bg-blue-300/20 rounded-full blur-3xl" />
      <div className="absolute bottom-0 left-10 w-[500px] h-[500px] bg-purple-300/20 rounded-full blur-3xl" />

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-12"
        >
          <span className="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-sm border border-white/80 text-slate-700 text-sm font-semibold mb-4 shadow-sm">
            Яагаад биднийг сонгох вэ?
          </span>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
            Shuurkhai-н давуу талууд
          </h2>
          <p className="text-base text-slate-600 max-w-2xl mx-auto">
            Таны хамгийн найдвартай карго түнш
          </p>
        </motion.div>

        {/* Main Benefits */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
          {benefits.map((benefit, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.4, delay: index * 0.08 }}
              whileHover={{ y: -6, scale: 1.02, transition: { duration: 0.2 } }}
              className="group"
            >
              <div className="h-full bg-white/50 backdrop-blur-xl rounded-3xl p-6 border border-white/60 shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                {/* Glass reflection */}
                <div className="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/60 via-white/30 to-transparent pointer-events-none" />
                
                {/* Hover glow */}
                <div className={`absolute inset-0 bg-gradient-to-br ${benefit.gradient} opacity-0 group-hover:opacity-10 rounded-3xl transition-opacity duration-300`} />
                
                <div className="relative">
                  <div className={`w-14 h-14 rounded-2xl bg-gradient-to-br ${benefit.gradient} flex items-center justify-center mb-4 shadow-md group-hover:scale-110 transition-transform duration-300`}>
                    <benefit.icon className="w-7 h-7 text-white" />
                  </div>
                  <h3 className="text-lg font-bold text-slate-900 mb-2">
                    {benefit.title}
                  </h3>
                  <p className="text-sm text-slate-600 leading-relaxed">
                    {benefit.desc}
                  </p>
                </div>
              </div>
            </motion.div>
          ))}
        </div>

        {/* Additional Benefits Banner */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ delay: 0.3 }}
          className="bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden mb-12 border border-white/10 shadow-2xl"
        >
          <div className="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
          <div className="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl" />
          
          {/* Glass reflection */}
          <div className="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/10 via-transparent to-transparent pointer-events-none" />
          
          <div className="relative grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {additionalBenefits.map((item, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                viewport={{ once: true }}
                transition={{ delay: 0.4 + index * 0.1 }}
                className="flex items-center gap-3"
              >
                <div className="w-11 h-11 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/20">
                  <item.icon className="w-5 h-5 text-emerald-400" />
                </div>
                <span className="text-white font-semibold text-sm">{item.text}</span>
              </motion.div>
            ))}
          </div>
        </motion.div>

        {/* Trust Indicators */}
        <motion.div
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          transition={{ delay: 0.5 }}
          className="text-center"
        >
          <p className="text-slate-500 mb-6 text-sm font-medium">Итгэлтэй түншүүд</p>
          <div className="flex flex-wrap justify-center gap-6 opacity-50">
            {['🏛️ Банк', '🏢 Даатгал', '📦 FedEx', '✈️ UPS', '🚚 DHL'].map((partner, i) => (
              <span key={i} className="text-base font-medium text-slate-400">{partner}</span>
            ))}
          </div>
        </motion.div>
      </div>
    </section>
  );
}