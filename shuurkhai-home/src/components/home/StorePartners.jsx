import React, { useRef } from 'react';
import { motion } from 'framer-motion';
import { ExternalLink, ChevronLeft, ChevronRight, ArrowRight } from 'lucide-react';
import { Button } from "@/components/ui/button";

const stores = [
  { name: 'Amazon', logo: '📦', color: 'from-orange-400 to-orange-500', desc: 'Дэлхийн хамгийн том' },
  { name: 'Walmart', logo: '🛒', color: 'from-blue-500 to-blue-600', desc: 'Хямд үнэтэй бараа' },
  { name: 'Target', logo: '🎯', color: 'from-red-500 to-red-600', desc: 'Чанартай бүтээгдэхүүн' },
  { name: 'eBay', logo: '🏷️', color: 'from-yellow-500 to-orange-500', desc: 'Дуудлага худалдаа' },
  { name: 'Best Buy', logo: '💻', color: 'from-blue-600 to-blue-700', desc: 'Электрон бараа' },
  { name: 'Apple Store', logo: '🍎', color: 'from-slate-700 to-slate-800', desc: 'Apple бүтээгдэхүүн' },
  { name: 'Nike', logo: '👟', color: 'from-orange-500 to-red-500', desc: 'Спорт хувцас' },
  { name: 'Adidas', logo: '⚽', color: 'from-blue-600 to-indigo-600', desc: 'Спортын бүтээгдэхүүн' },
  { name: 'Macys', logo: '👔', color: 'from-red-500 to-pink-600', desc: 'Хувцас, гоо сайхан' },
  { name: 'Home Depot', logo: '🔨', color: 'from-orange-600 to-red-600', desc: 'Барилгын материал' },
  { name: 'IKEA', logo: '🛋️', color: 'from-blue-500 to-yellow-500', desc: 'Тавилга, гэр ахуй' },
  { name: 'Costco', logo: '🏪', color: 'from-red-600 to-blue-600', desc: 'Бөөний худалдаа' },
  { name: 'Samsung', logo: '📱', color: 'from-blue-700 to-cyan-600', desc: 'Электроникс' },
  { name: 'Sephora', logo: '💄', color: 'from-pink-500 to-purple-600', desc: 'Гоо сайхны бүтээгдэхүүн' },
  { name: 'Zara', logo: '👗', color: 'from-gray-700 to-slate-800', desc: 'Загварын хувцас' },
  { name: 'H&M', logo: '👕', color: 'from-red-500 to-pink-500', desc: 'Загварын хувцас' },
  { name: 'Forever 21', logo: '👚', color: 'from-pink-500 to-purple-500', desc: 'Залуучуудын хувцас' },
  { name: 'Victorias Secret', logo: '🎀', color: 'from-pink-400 to-rose-500', desc: 'Эмэгтэй хувцас' },
  { name: 'Levis', logo: '👖', color: 'from-blue-600 to-indigo-700', desc: 'Жинсэн хувцас' },
  { name: 'Gap', logo: '🧥', color: 'from-blue-500 to-slate-600', desc: 'Энгийн хувцас' },
  { name: 'Puma', logo: '🐆', color: 'from-slate-700 to-red-600', desc: 'Спорт хувцас' },
];

export default function StorePartners() {
  const scrollRef = useRef(null);
  const [isDragging, setIsDragging] = React.useState(false);
  const [startX, setStartX] = React.useState(0);
  const [scrollLeft, setScrollLeft] = React.useState(0);

  const scroll = (direction) => {
    if (scrollRef.current) {
      const scrollAmount = 300;
      scrollRef.current.scrollBy({
        left: direction === 'left' ? -scrollAmount : scrollAmount,
        behavior: 'smooth'
      });
    }
  };

  const handleMouseDown = (e) => {
    setIsDragging(true);
    setStartX(e.pageX - scrollRef.current.offsetLeft);
    setScrollLeft(scrollRef.current.scrollLeft);
  };

  const handleMouseUp = () => {
    setIsDragging(false);
  };

  const handleMouseMove = (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - scrollRef.current.offsetLeft;
    const walk = (x - startX) * 2;
    scrollRef.current.scrollLeft = scrollLeft - walk;
  };

  return (
    <section className="py-20 bg-gradient-to-b from-white via-slate-50 to-white relative overflow-hidden">
      {/* Decorative elements */}
      <div className="absolute top-10 left-20 w-72 h-72 bg-blue-200/20 rounded-full blur-3xl" />
      <div className="absolute bottom-10 right-20 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl" />
      
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="text-center mb-12"
        >
          <span className="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-slate-700 text-sm font-semibold mb-4">
            Онлайн дэлгүүрүүд
          </span>
          <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
            Манай хамтрагч онлайн дэлгүүрүүд
          </h2>
          <p className="text-base text-slate-600 max-w-2xl mx-auto">
            Америкийн найдвартай онлайн дэлгүүрүүдээс шууд захиална
          </p>
        </motion.div>

        {/* Scroll Buttons */}
        <div className="flex items-center justify-between mb-6">
          <div className="flex gap-2">
            <button
              onClick={() => scroll('left')}
              className="w-10 h-10 rounded-xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm hover:shadow-md hover:bg-white/80 transition-all duration-200 flex items-center justify-center"
            >
              <ChevronLeft className="w-5 h-5 text-slate-700" />
            </button>
            <button
              onClick={() => scroll('right')}
              className="w-10 h-10 rounded-xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm hover:shadow-md hover:bg-white/80 transition-all duration-200 flex items-center justify-center"
            >
              <ChevronRight className="w-5 h-5 text-slate-700" />
            </button>
          </div>
          <Button 
            variant="ghost" 
            className="text-slate-700 hover:text-slate-900 font-semibold text-sm group"
          >
            Бүгдийг харах
            <ArrowRight className="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" />
          </Button>
        </div>

        {/* Horizontal Scroll Container */}
        <div 
          ref={scrollRef}
          onMouseDown={handleMouseDown}
          onMouseUp={handleMouseUp}
          onMouseLeave={handleMouseUp}
          onMouseMove={handleMouseMove}
          className="flex gap-3 sm:gap-4 overflow-x-auto scrollbar-hide scroll-smooth pb-4 cursor-grab active:cursor-grabbing select-none"
          style={{ scrollbarWidth: 'none', msOverflowStyle: 'none' }}
        >
          {stores.map((store, index) => (
            <motion.div
              key={store.name}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.4, delay: index * 0.03 }}
              whileHover={{ y: -6, transition: { duration: 0.2 } }}
              className="group cursor-pointer flex-shrink-0 w-[160px]"
            >
              <div className="relative bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-white/80 shadow-sm hover:shadow-xl hover:bg-white/80 transition-all duration-300 h-full">
                {/* Gradient glow on hover */}
                <div className={`absolute inset-0 bg-gradient-to-br ${store.color} opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300`} />
                
                {/* Glass reflection effect */}
                <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 via-white/10 to-transparent opacity-50 pointer-events-none" />
                
                <div className="relative">
                  <div className="text-3xl mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    {store.logo}
                  </div>
                  <h3 className="font-bold text-slate-900 mb-1 text-sm">{store.name}</h3>
                  <p className="text-xs text-slate-500 leading-snug">{store.desc}</p>
                  
                  <div className="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity">
                    <ExternalLink className="w-3.5 h-3.5 text-slate-400" />
                  </div>
                </div>
              </div>
            </motion.div>
          ))}
        </div>

        {/* Trust Badge */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ delay: 0.3 }}
          className="mt-8 text-center"
        >
          <div className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/60 backdrop-blur-sm border border-emerald-200/60 shadow-sm">
            <span className="text-emerald-500 text-base">✓</span>
            <span className="text-emerald-700 font-semibold text-sm">Бүх дэлгүүрээс 100% баталгаатай захиалга</span>
          </div>
        </motion.div>
      </div>
    </section>
  );
}