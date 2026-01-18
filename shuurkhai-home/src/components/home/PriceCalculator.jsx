import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Calculator, Plane, Ship, Package, ArrowRight } from 'lucide-react';
import { Button } from "@/components/ui/button";
import { Slider } from "@/components/ui/slider";

export default function PriceCalculator() {
  const [weight, setWeight] = useState(5);
  const [cargoType, setCargoType] = useState('air');

  const calculatePrice = () => {
    const baseRate = cargoType === 'air' ? 12 : 4;
    return (weight * baseRate).toFixed(0);
  };

  const deliveryTime = cargoType === 'air' ? '5-10 хоног' : '25-45 хоног';

  return (
    <section className="py-24 bg-slate-900 relative overflow-hidden">
      {/* Background Elements */}
      <div className="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]" />
      <div className="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
      <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Left Content */}
          <motion.div
            initial={{ opacity: 0, x: -30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
          >
            <span className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-white/80 text-sm font-medium mb-6">
              <Calculator className="w-4 h-4" />
              Үнийн тооцоолуур
            </span>
            <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
              Карго үнээ
              <span className="text-orange-400"> шууд</span> тооцоол
            </h2>
            <p className="text-lg text-white/70 mb-8 max-w-lg">
              Жин болон карго төрлийг сонгоод үнийн мэдээллээ авна уу. Илүү дэлгэрэнгүй мэдээлэл авахыг хүсвэл бидэнтэй холбогдоорой.
            </p>

            <div className="flex flex-wrap gap-4">
              <div className="flex items-center gap-3 text-white/60">
                <div className="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                  <Package className="w-5 h-5 text-emerald-400" />
                </div>
                <span>Нэмэлт зардалгүй</span>
              </div>
              <div className="flex items-center gap-3 text-white/60">
                <div className="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                  <Calculator className="w-5 h-5 text-emerald-400" />
                </div>
                <span>Ил тод үнэ</span>
              </div>
            </div>
          </motion.div>

          {/* Calculator Card */}
          <motion.div
            initial={{ opacity: 0, x: 30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ delay: 0.2 }}
          >
            <div className="bg-white rounded-3xl p-8 shadow-2xl">
              {/* Cargo Type Selection */}
              <div className="mb-8">
                <label className="text-sm font-medium text-slate-600 mb-3 block">
                  Карго төрөл
                </label>
                <div className="grid grid-cols-2 gap-4">
                  {[
                    { type: 'air', icon: Plane, label: 'Агаар', time: '5-10 хоног' },
                    { type: 'sea', icon: Ship, label: 'Далай', time: '25-45 хоног' },
                  ].map((option) => (
                    <button
                      key={option.type}
                      onClick={() => setCargoType(option.type)}
                      className={`p-4 rounded-2xl border-2 transition-all ${
                        cargoType === option.type
                          ? 'border-slate-900 bg-slate-50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}
                    >
                      <option.icon className={`w-8 h-8 mx-auto mb-2 ${
                        cargoType === option.type ? 'text-slate-900' : 'text-slate-400'
                      }`} />
                      <p className={`font-semibold ${
                        cargoType === option.type ? 'text-slate-900' : 'text-slate-600'
                      }`}>{option.label}</p>
                      <p className="text-xs text-slate-400 mt-1">{option.time}</p>
                    </button>
                  ))}
                </div>
              </div>

              {/* Weight Slider */}
              <div className="mb-8">
                <div className="flex justify-between items-center mb-3">
                  <label className="text-sm font-medium text-slate-600">
                    Жин (кг)
                  </label>
                  <span className="text-2xl font-bold text-[#1e3a5f]">{weight} кг</span>
                </div>
                <Slider
                  value={[weight]}
                  onValueChange={(value) => setWeight(value[0])}
                  min={1}
                  max={100}
                  step={1}
                  className="py-4"
                />
                <div className="flex justify-between text-xs text-slate-400 mt-1">
                  <span>1 кг</span>
                  <span>100 кг</span>
                </div>
              </div>

              {/* Result */}
              <div className="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-6 mb-6">
                <div className="flex justify-between items-center mb-4">
                  <span className="text-slate-600">Тооцоолсон үнэ</span>
                  <span className="text-sm text-slate-400">{deliveryTime}</span>
                </div>
                <div className="flex items-baseline gap-1">
                  <span className="text-5xl font-bold text-slate-900">${calculatePrice()}</span>
                  <span className="text-slate-500">USD</span>
                </div>
                <p className="text-sm text-slate-400 mt-2">
                  * Энэ нь ойролцоо үнэ бөгөөд барааны хэмжээнээс хамаарч өөрчлөгдөж болно
                </p>
              </div>

              <Button 
                className="w-full bg-slate-900 hover:bg-slate-800 text-white py-6 rounded-2xl text-lg shadow-sm group"
              >
                Үнийн тооцоо хийх
                <ArrowRight className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
              </Button>
            </div>
          </motion.div>
        </div>
      </div>
    </section>
  );
}