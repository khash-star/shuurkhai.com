import React from 'react';
import { motion } from 'framer-motion';
import { ShoppingCart, Send, Warehouse, Plane, CheckCircle } from 'lucide-react';

const steps = [
  {
    icon: ShoppingCart,
    title: 'Бараа сонгоно',
    desc: 'Онлайн дэлгүүрээс хүссэн барааг сонгоно',
    gradient: 'from-blue-500 to-indigo-600',
    bgGradient: 'from-blue-50 via-indigo-50 to-purple-50',
    number: '1',
  },
  {
    icon: Send,
    title: 'Захиалга илгээнэ',
    desc: 'Shuurkhai-д захиалгаа илгээнэ',
    gradient: 'from-indigo-500 to-purple-600',
    bgGradient: 'from-indigo-50 via-purple-50 to-pink-50',
    number: '2',
  },
  {
    icon: Warehouse,
    title: 'Агуулахад хүлээн авна',
    desc: 'АНУ дахь агуулахад бараа ирнэ',
    gradient: 'from-purple-500 to-pink-600',
    bgGradient: 'from-purple-50 via-pink-50 to-rose-50',
    number: '3',
  },
  {
    icon: Plane,
    title: 'Карго илгээлт',
    desc: 'Агаар / далайн каргоор илгээнэ',
    gradient: 'from-orange-500 to-red-600',
    bgGradient: 'from-orange-50 via-red-50 to-pink-50',
    number: '4',
  },
  {
    icon: CheckCircle,
    title: 'Хүлээн авна',
    desc: 'Монголд барааг хүлээн авна',
    gradient: 'from-emerald-500 to-green-600',
    bgGradient: 'from-emerald-50 via-green-50 to-teal-50',
    number: '5',
  },
];

export default function HowItWorks() {
  return (
    <section className="py-20 bg-white relative overflow-hidden">
      {/* Decorative Elements */}
      <div className="absolute top-20 left-10 w-64 h-64 bg-blue-100/30 rounded-full blur-3xl" />
      <div className="absolute bottom-20 right-10 w-80 h-80 bg-purple-100/30 rounded-full blur-3xl" />

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-12"
        >
          <span className="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-slate-700 text-sm font-semibold mb-4">
            Хэрхэн ажилладаг вэ?
          </span>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
            5 амархан алхам
          </h2>
          <p className="text-base text-slate-600 max-w-2xl mx-auto">
            Америк барааг Монголд авах хамгийн хялбар арга
          </p>
        </motion.div>

        {/* Steps - Desktop */}
        <div className="hidden lg:grid lg:grid-cols-5 gap-3 relative">
          {steps.map((step, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: index * 0.1 }}
              className="relative group"
            >
              <div className={`relative bg-gradient-to-br ${step.bgGradient} rounded-2xl p-5 border border-white/60 shadow-sm hover:shadow-xl transition-all duration-300 h-full`}>
                {/* Number Badge */}
                <div className="absolute -top-3 -left-3 z-20">
                  <div className={`w-9 h-9 rounded-xl bg-gradient-to-br ${step.gradient} shadow-lg flex items-center justify-center`}>
                    <span className="text-white font-bold text-base">{step.number}</span>
                  </div>
                </div>

                {/* Icon */}
                <motion.div
                  whileHover={{ scale: 1.05, rotate: 5 }}
                  className={`w-14 h-14 rounded-xl bg-gradient-to-br ${step.gradient} flex items-center justify-center mb-4 mx-auto mt-2 shadow-md`}
                >
                  <step.icon className="w-7 h-7 text-white" />
                </motion.div>

                {/* Content */}
                <h3 className="font-bold text-slate-900 text-center mb-2 text-base">
                  {step.title}
                </h3>
                <p className="text-xs text-slate-600 text-center leading-relaxed">
                  {step.desc}
                </p>

                {/* Decorative element */}
                <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" />
              </div>

              {/* Arrow connector */}
              {index < steps.length - 1 && (
                <div className="absolute top-1/2 -right-1.5 -translate-y-1/2 z-10 hidden xl:block">
                  <div className="w-3 h-3 rotate-45 bg-slate-300"></div>
                </div>
              )}
            </motion.div>
          ))}
        </div>

        {/* Steps - Mobile */}
        <div className="lg:hidden space-y-4">
          {steps.map((step, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.4, delay: index * 0.08 }}
              className="relative"
            >
              <div className={`relative bg-gradient-to-br ${step.bgGradient} rounded-2xl p-4 border border-white/60 shadow-sm`}>
                <div className="flex items-start gap-3">
                  {/* Number + Icon */}
                  <div className="relative flex-shrink-0">
                    <div className="absolute -top-2 -left-2 z-10">
                      <div className={`w-7 h-7 rounded-lg bg-gradient-to-br ${step.gradient} shadow-md flex items-center justify-center`}>
                        <span className="text-white font-bold text-sm">{step.number}</span>
                      </div>
                    </div>
                    <div className={`w-12 h-12 rounded-xl bg-gradient-to-br ${step.gradient} flex items-center justify-center shadow-md`}>
                      <step.icon className="w-6 h-6 text-white" />
                    </div>
                  </div>
                  
                  {/* Content */}
                  <div className="flex-1 pt-1">
                    <h3 className="font-bold text-slate-900 mb-1 text-sm">{step.title}</h3>
                    <p className="text-xs text-slate-600 leading-relaxed">{step.desc}</p>
                  </div>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}