import Hero from '../components/home/Hero';
import FeaturedProducts from '../components/home/FeaturedProducts';
import { Link } from 'react-router-dom';
import { CheckCircle, Award, Users, Clock, ArrowRight, ShoppingCart, Phone, Star } from 'lucide-react';
import { useEffect, useState } from 'react';
import { apiService } from '../services/api';
import { motion } from 'framer-motion';

const fallbackFeatures = [
  { icon: '💻', title: 'Expert Repairs', description: 'Chip-level repairs by certified technicians.' },
  { icon: '⚡', title: 'Quick Service', description: 'Fast turnaround for all repairs and upgrades.' },
  { icon: '🤝', title: 'Trusted Support', description: '500+ happy customers and 3+ years experience.' },
  { icon: '🔒', title: 'Quality Guarantee', description: 'All work covered by warranty and support.' },
];

const Home = () => {
  const [features, setFeatures] = useState(fallbackFeatures);

  useEffect(() => {
    fetch('http://localhost:8000/api/features')
      .then(res => res.json())
      .then(data => {
        if (data.success && data.data && data.data.length > 0) {
          setFeatures(data.data.map((f: any) => ({
            icon: f.icon || '⭐',
            title: f.title,
            description: f.description,
          })));
        }
      })
      .catch(() => setFeatures(fallbackFeatures));
  }, []);

  return (
    <div>
      <Hero />
      <FeaturedProducts />
      
      {/* Why Choose Us Section */}
      <section className="py-20 bg-white">
        <div className="container">
          <div className="text-center mb-16">
            <motion.h2 
              className="text-4xl font-bold text-gray-900 mb-6"
              initial={{ opacity: 0, y: 40 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.7 }}
            >
              Why Choose <span className="text-blue-600">zinlink techs</span>
            </motion.h2>
            <motion.p 
              className="text-xl text-gray-600 max-w-3xl mx-auto"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.2, duration: 0.7 }}
            >
              We're committed to providing the best tech solutions with unmatched service and support.
            </motion.p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {features.map((feature, idx) => (
              <motion.div
                key={idx}
                className="bg-white/70 backdrop-blur-lg rounded-2xl p-8 text-center shadow-xl hover:shadow-2xl transition relative border border-blue-100"
                initial={{ opacity: 0, y: 40 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.2 + idx * 0.15, duration: 0.7 }}
              >
                <div className="text-4xl mb-4 animate-bounce-slow">{feature.icon}</div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">{feature.title}</h3>
                <p className="text-gray-600 text-sm">{feature.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>
      
      {/* Categories Section */}
      <section className="py-20 bg-gradient-to-br from-blue-50 to-purple-50">
        <div className="container">
          <div className="text-center mb-16">
            <motion.h2 
              className="text-4xl font-bold text-gray-900 mb-6"
              initial={{ opacity: 0, y: 40 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.7 }}
            >
              Explore Our <span className="text-blue-600">Categories</span>
            </motion.h2>
            <motion.p 
              className="text-xl text-gray-600 max-w-3xl mx-auto"
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: 0.2, duration: 0.7 }}
            >
              From gaming laptops to business solutions, we have everything you need.
            </motion.p>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {/* Animated category cards */}
            <motion.div whileHover={{ scale: 1.05 }} className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-transparent hover:border-blue-200 cursor-pointer">
              <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                <span className="text-2xl">💻</span>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">Laptops</h3>
              <p className="text-gray-600 mb-4">Premium laptops for work, gaming, and everyday use.</p>
              <div className="flex items-center text-blue-600 font-medium">
                <span>Explore</span>
                <ArrowRight className="w-4 h-4 ml-2" />
              </div>
            </motion.div>
            <motion.div whileHover={{ scale: 1.05 }} className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-transparent hover:border-green-200 cursor-pointer">
              <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <span className="text-2xl">🎮</span>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">Gaming Laptops</h3>
              <p className="text-gray-600 mb-4">High-performance gaming machines for ultimate gaming experience.</p>
              <div className="flex items-center text-green-600 font-medium">
                <span>Explore</span>
                <ArrowRight className="w-4 h-4 ml-2" />
              </div>
            </motion.div>
            <motion.div whileHover={{ scale: 1.05 }} className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-transparent hover:border-purple-200 cursor-pointer">
              <div className="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                <span className="text-2xl">🔧</span>
              </div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">Accessories</h3>
              <p className="text-gray-600 mb-4">Essential accessories to enhance your computing experience.</p>
              <div className="flex items-center text-purple-600 font-medium">
                <span>Explore</span>
                <ArrowRight className="w-4 h-4 ml-2" />
              </div>
            </motion.div>
          </div>
        </div>
      </section>
      {/* Testimonial Slider Placeholder */}
      <section className="py-20 bg-white">
        <div className="container">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
            <p className="text-gray-600">(Testimonial slider coming soon...)</p>
          </div>
        </div>
      </section>

      {/* Quick Actions Section */}
      <section className="py-16 bg-white">
        <div className="container">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <p className="text-gray-600">Get started with these popular actions</p>
          </div>
          
          <div className="grid md:grid-cols-3 gap-6">
            <Link to="/products" className="group">
              <div className="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div className="flex items-center justify-between mb-4">
                  <ShoppingCart className="w-8 h-8" />
                  <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" />
                </div>
                <h3 className="text-xl font-semibold mb-2">Shop Products</h3>
                <p className="text-blue-100">Browse our extensive collection of laptops and accessories</p>
              </div>
            </Link>
            
            <Link to="/contact" className="group">
              <div className="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div className="flex items-center justify-between mb-4">
                  <Phone className="w-8 h-8" />
                  <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" />
                </div>
                <h3 className="text-xl font-semibold mb-2">Contact Support</h3>
                <p className="text-green-100">Get help from our expert technical support team</p>
              </div>
            </Link>
            
            <Link to="/admin" className="group">
              <div className="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div className="flex items-center justify-between mb-4">
                  <Star className="w-8 h-8" />
                  <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" />
                </div>
                <h3 className="text-xl font-semibold mb-2">Admin Panel</h3>
                <p className="text-purple-100">Manage products and view analytics dashboard</p>
              </div>
            </Link>
          </div>
        </div>
      </section>
      
      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-r from-blue-600 to-blue-700">
        <div className="container">
          <div className="text-center">
            <h2 className="text-4xl font-bold text-white mb-6">
              Ready to Get Started?
            </h2>
            <p className="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
              Join thousands of satisfied customers who trust zinlink techs for their tech needs.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link 
                to="/products" 
                className="btn-primary inline-flex items-center px-8 py-4 font-semibold rounded-lg transform hover:scale-105 active:scale-95"
              >
                <ShoppingCart className="w-5 h-5 mr-2" />
                Shop Now
              </Link>
              <Link 
                to="/contact" 
                className="btn-outline border-white text-white hover:bg-white hover:text-blue-600 inline-flex items-center px-8 py-4 font-semibold rounded-lg transform hover:scale-105 active:scale-95"
              >
                <Phone className="w-5 h-5 mr-2" />
                Contact Us
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Home;