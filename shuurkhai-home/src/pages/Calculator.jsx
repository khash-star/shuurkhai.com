import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Calculator, Plane, Ship, Package, ArrowRight } from 'lucide-react';
import { Button } from "@/components/ui/button";
import { Slider } from "@/components/ui/slider";

export default function CalculatorPage() {
  const [weight, setWeight] = useState(5);
  const [cargoType, setCargoType] = useState('air');

  const calculatePrice = () => {
    const baseRate = cargoType === 'air' ? 12 : 4;
    return (weight * baseRate).toFixed(0);
  };

  const deliveryTime = cargoType === 'air' ? '5-10 хоног' : '25-45 хоног';

  return (
    <div className="min-h-screen bg-slate-900 relative overflow-hidden pt-20">
      {/* Background Elements */}
      <div className="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]" />
      <div className="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
      <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative py-24">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Left Content */}
          <motion.div
            initial={{ opacity: 0, x: -30 }}
            animate={{ opacity: 1, x: 0 }}
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
              <div className="flex items-center gap-3 px-4 py-2 rounded-xl bg-white/50 backdrop-blur-sm border border-white/60 shadow-sm">
                <div className="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-md">
                  <Package className="w-4 h-4 text-white" />
                </div>
                <span className="text-sm font-semibold text-slate-700">Нэмэлт зардалгүй</span>
              </div>
              <div className="flex items-center gap-3 px-4 py-2 rounded-xl bg-white/50 backdrop-blur-sm border border-white/60 shadow-sm">
                <div className="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                  <Calculator className="w-4 h-4 text-white" />
                </div>
                <span className="text-sm font-semibold text-slate-700">Ил тод үнэ</span>
              </div>
            </div>
          </motion.div>

          {/* Calculator Card */}
          <motion.div
            initial={{ opacity: 0, x: 30 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ delay: 0.2 }}
          >
            <div className="bg-white rounded-3xl p-8 shadow-2xl">
              {/* Cargo Type Selection */}
              <div className="mb-8 relative">
                <label className="text-sm font-semibold text-slate-700 mb-3 block">
                  Карго төрөл
                </label>
                <div className="grid grid-cols-2 gap-3">
                  {[
                    { type: 'air', icon: Plane, label: 'Агаар', time: '5-10 хоног', gradient: 'from-blue-500 to-blue-600' },
                    { type: 'sea', icon: Ship, label: 'Далай', time: '25-45 хоног', gradient: 'from-emerald-500 to-emerald-600' },
                  ].map((option) => (
                    <button
                      key={option.type}
                      onClick={() => setCargoType(option.type)}
                      className={`p-4 rounded-2xl border-2 transition-all backdrop-blur-sm ${
                        cargoType === option.type
                          ? 'border-slate-900 bg-white/80 shadow-lg'
                          : 'border-white/60 bg-white/40 hover:bg-white/60 hover:border-slate-300'
                      }`}
                    >
                      <div className={`w-10 h-10 rounded-xl mx-auto mb-2 flex items-center justify-center ${
                        cargoType === option.type ? `bg-gradient-to-br ${option.gradient}` : 'bg-slate-100'
                      }`}>
                        <option.icon className={`w-6 h-6 ${
                          cargoType === option.type ? 'text-white' : 'text-slate-400'
                        }`} />
                      </div>
                      <p className={`font-bold text-sm ${
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
                  <span className="text-2xl font-bold text-slate-900">{weight} кг</span>
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
              <div className="bg-white/60 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-white/80 shadow-md relative overflow-hidden">
                {/* Glass effect */}
                <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 via-transparent to-transparent pointer-events-none" />
                
                <div className="relative">
                  <div className="flex justify-between items-center mb-4">
                    <span className="text-slate-700 font-semibold text-sm">Тооцоолсон үнэ</span>
                    <span className="text-xs text-slate-500 px-2 py-1 rounded-lg bg-white/60 backdrop-blur-sm">{deliveryTime}</span>
                  </div>
                  <div className="flex items-baseline gap-2">
                    <span className="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">${calculatePrice()}</span>
                    <span className="text-slate-500 font-semibold">USD</span>
                  </div>
                  <p className="text-xs text-slate-500 mt-3 leading-relaxed">
                    * Энэ нь ойролцоо үнэ бөгөөд барааны хэмжээнээс хамаарч өөрчлөгдөж болно
                  </p>
                </div>
              </div>

              <Button 
                className="w-full bg-gradient-to-r from-slate-900 to-slate-700 hover:from-slate-800 hover:to-slate-600 text-white py-6 rounded-2xl text-base shadow-lg group relative overflow-hidden"
              >
                <span className="relative z-10 flex items-center justify-center">
                  Үнийн тооцоо хийх
                  <ArrowRight className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
                </span>
              </Button>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  );
}