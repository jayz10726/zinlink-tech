import { Link } from 'react-router-dom';
import { Star, ChevronRight, Shield, Clock, Users, Award, CheckCircle, ArrowRight, Phone, MapPin } from 'lucide-react';
import { useState, useEffect } from 'react';
import { motion } from 'framer-motion';

const carouselImages = [
  {
    url: 'https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&dpr=2',
    alt: 'IT support team working together',
  },
  {
    url: 'https://images.pexels.com/photos/442152/pexels-photo-442152.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&dpr=2',
    alt: 'Close-up of hands repairing a computer',
  },
  {
    url: 'https://images.pexels.com/photos/3861968/pexels-photo-3861968.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&dpr=2',
    alt: 'Woman technician with a laptop',
  },
  {
    url: 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&dpr=2',
    alt: 'Modern workspace with multiple screens',
  },
];

const Hero = () => {
  const [current, setCurrent] = useState(0);
  const [parallax, setParallax] = useState({ x: 0, y: 0 });

  useEffect(() => {
    // Parallax mouse move
    const handleMouseMove = (e: MouseEvent) => {
      const x = (e.clientX / window.innerWidth - 0.5) * 30;
      const y = (e.clientY / window.innerHeight - 0.5) * 30;
      setParallax({ x, y });
    };
    window.addEventListener('mousemove', handleMouseMove);
    return () => window.removeEventListener('mousemove', handleMouseMove);
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrent((prev) => (prev + 1) % carouselImages.length);
    }, 4000); // 4 seconds per image
    return () => clearInterval(interval);
  }, [carouselImages.length]);

  return (
    <section className="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
      {/* Carousel Background Images with Parallax */}
      {carouselImages.map((img, idx) => (
        <img
          key={img.url}
          src={img.url}
          alt={img.alt}
          className={`absolute inset-0 w-full h-full object-cover object-center z-0 transition-opacity duration-1000 ${current === idx ? 'opacity-100' : 'opacity-0'}`}
          style={{ filter: 'brightness(0.5) blur(1px)', transform: `translate3d(${parallax.x}px, ${parallax.y}px, 0)` }}
        />
      ))}
      {/* Overlay */}
      <div className="absolute inset-0 bg-gradient-to-br from-black/70 via-black/40 to-blue-900/60 z-10" />
      {/* Content */}
      <div className="relative z-20 w-full max-w-3xl mx-auto text-center px-4 py-24">
        <div className="inline-flex items-center px-6 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-base font-semibold border border-white/30 mb-8 shadow-lg">
          <Star className="w-5 h-5 mr-2 text-yellow-400" />
          Your Local Tech Experts
        </div>
        <motion.h1
          className="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg leading-tight bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 bg-clip-text text-transparent animate-gradient-move"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 1 }}
        >
          Professional Computer Solutions
        </motion.h1>
        <motion.p
          className="text-xl md:text-2xl text-gray-200 mb-10 max-w-2xl mx-auto"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.3, duration: 1 }}
        >
          Laptop & desktop sales, expert repairs, data recovery, and CCTV installation in Kisumu City. Trusted by 500+ happy customers.
        </motion.p>
        <div className="flex flex-col sm:flex-row gap-6 justify-center">
          <Link
            to="/products"
            className="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 text-lg group"
          >
            Shop Now
            <ChevronRight className="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" />
          </Link>
          <Link
            to="/contact"
            className="inline-flex items-center justify-center px-8 py-4 bg-white/20 border-2 border-white/30 text-white font-bold rounded-xl shadow-lg hover:bg-white/30 transition-all duration-300 text-lg"
          >
            <Phone className="w-6 h-6 mr-2" />
            Contact Us
          </Link>
        </div>
      </div>
    </section>
  );
};

export default Hero;