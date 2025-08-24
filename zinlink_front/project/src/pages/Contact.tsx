import { useState } from 'react';
import { Mail, Phone, MapPin, Clock, Send } from 'lucide-react';
import { FaWhatsapp } from 'react-icons/fa';
import { motion } from 'framer-motion';

const Contact = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    subject: '',
    message: ''
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // Handle form submission here
    console.log('Form submitted:', formData);
    // Reset form
    setFormData({
      name: '',
      email: '',
      subject: '',
      message: ''
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-12">
      <div className="container">
        {/* Header */}
        <motion.div className="text-center mb-12"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h1 className="text-4xl font-extrabold text-primary-900 mb-4 drop-shadow-lg">Contact Us</h1>
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            Have questions about our products or need support? We're here to help!
          </p>
        </motion.div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Contact Information */}
          <motion.div className="lg:col-span-1 space-y-6"
            initial={{ opacity: 0, x: -40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.7, delay: 0.2 }}
          >
            <div className="bg-white/70 backdrop-blur-lg rounded-2xl shadow-2xl p-6 border border-blue-100">
              <h3 className="text-lg font-bold text-gray-900 mb-4">Get in Touch</h3>
              <div className="space-y-4">
                <div className="flex items-start gap-3">
                  <MapPin className="w-5 h-5 text-secondary-600 mt-1 flex-shrink-0" />
                  <div>
                    <p className="font-medium text-gray-900">Address</p>
                    <p className="text-gray-600 text-sm">Mamboleo<br /></p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <Phone className="w-5 h-5 text-secondary-600 mt-1 flex-shrink-0 animate-pulse" />
                  <div>
                    <p className="font-medium text-gray-900">Phone</p>
                    <p className="text-gray-600 text-sm">0746049506/0768244011</p>
                    <div className="flex flex-wrap gap-2 mt-2">
                      <motion.a
                        href="https://wa.me/254746049506"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition-colors text-sm font-semibold focus:ring-2 focus:ring-green-400 animate-bounce"
                        whileHover={{ scale: 1.08, boxShadow: '0 0 16px #25D366' }}
                      >
                        <FaWhatsapp className="w-5 h-5 mr-2 animate-spin-slow" />
                        Chat on WhatsApp
                      </motion.a>
                      <motion.a
                        href="https://wa.me/254768244011"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition-colors text-sm font-semibold focus:ring-2 focus:ring-green-400 animate-bounce"
                        whileHover={{ scale: 1.08, boxShadow: '0 0 16px #25D366' }}
                      >
                        <FaWhatsapp className="w-5 h-5 mr-2 animate-spin-slow" />
                        Chat on WhatsApp 2
                      </motion.a>
                    </div>
                  </div>
                </div>

                <div className="flex items-start gap-3">
                  <Mail className="w-5 h-5 text-secondary-600 mt-1 flex-shrink-0" />
                  <div>
                    <p className="font-medium text-gray-900">Email</p>
                            <p className="text-gray-600 text-sm">support@zinlink techs.com</p>
        <p className="text-gray-600 text-sm">sales@zinlink techs.com</p>
                  </div>
                </div>

                <div className="flex items-start gap-3">
                  <Clock className="w-5 h-5 text-secondary-600 mt-1 flex-shrink-0" />
                  <div>
                    <p className="font-medium text-gray-900">Business Hours</p>
                    <p className="text-gray-600 text-sm">
                      Monday - Friday: 9:00 AM - 6:00 PM PST<br />
                      Saturday: 10:00 AM - 4:00 PM PST<br />
                      Sunday: Closed
                    </p>
                  </div>
                </div>
              </div>
            </div>

            {/* Support Categories */}
            <div className="bg-white rounded-lg shadow-sm p-6">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Support Categories</h3>
              <div className="space-y-3">
                <div className="p-3 bg-gray-50 rounded-md">
                  <h4 className="font-medium text-gray-900">Technical Support</h4>
                  <p className="text-sm text-gray-600">Hardware issues, software problems, troubleshooting</p>
                </div>
                <div className="p-3 bg-gray-50 rounded-md">
                  <h4 className="font-medium text-gray-900">Sales Inquiries</h4>
                  <p className="text-sm text-gray-600">Product information, pricing, bulk orders</p>
                </div>
                <div className="p-3 bg-gray-50 rounded-md">
                  <h4 className="font-medium text-gray-900">Returns & Warranty</h4>
                  <p className="text-sm text-gray-600">Return process, warranty claims, exchanges</p>
                </div>
              </div>
            </div>
          </motion.div>

          {/* Contact Form */}
          <motion.div className="lg:col-span-2"
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.7, delay: 0.3 }}
          >
            <div className="bg-white/70 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-blue-100">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="relative">
                    <input
                      type="text"
                      id="name"
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      required
                      className="input peer bg-transparent border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0 rounded-none placeholder-transparent"
                      placeholder="Your full name"
                    />
                    <label htmlFor="name" className="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-600">Full Name *</label>
                  </div>
                  <div className="relative">
                    <input
                      type="email"
                      id="email"
                      name="email"
                      value={formData.email}
                      onChange={handleChange}
                      required
                      className="input peer bg-transparent border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0 rounded-none placeholder-transparent"
                      placeholder="your.email@example.com"
                    />
                    <label htmlFor="email" className="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-600">Email Address *</label>
                  </div>
                </div>
                <div className="relative">
                  <select
                    id="subject"
                    name="subject"
                    value={formData.subject}
                    onChange={handleChange}
                    required
                    className="input peer bg-transparent border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0 rounded-none placeholder-transparent"
                  >
                    <option value="" disabled>Select a subject</option>
                    <option value="technical-support">Technical Support</option>
                    <option value="sales-inquiry">Sales Inquiry</option>
                    <option value="returns-warranty">Returns & Warranty</option>
                    <option value="general-question">General Question</option>
                    <option value="feedback">Feedback</option>
                  </select>
                  <label htmlFor="subject" className="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-focus:text-blue-600">Subject *</label>
                </div>
                <div className="relative">
                  <textarea
                    id="message"
                    name="message"
                    value={formData.message}
                    onChange={handleChange}
                    required
                    rows={6}
                    className="input peer bg-transparent border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0 rounded-none placeholder-transparent resize-none"
                    placeholder="Please describe your inquiry in detail..."
                  />
                  <label htmlFor="message" className="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-600">Message *</label>
                </div>
                <div className="flex items-center gap-2">
                  <input
                    type="checkbox"
                    id="newsletter"
                    className="rounded border-gray-300 text-secondary-600 focus:ring-secondary-500"
                  />
                  <label htmlFor="newsletter" className="text-sm text-gray-600">
                    I'd like to receive updates about new products and offers
                  </label>
                </div>
                <motion.button
                  type="submit"
                  className="btn-secondary w-full md:w-auto"
                  whileTap={{ scale: 0.97 }}
                  whileHover={{ scale: 1.03 }}
                >
                  <Send className="w-5 h-5 mr-2" />
                  Send Message
                </motion.button>
              </form>
            </div>
          </motion.div>
        </div>

        {/* FAQ Section */}
        <motion.div className="mt-16"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.4 }}
        >
          <div className="text-center mb-8">
            <h2 className="text-3xl font-bold text-primary-900 mb-4">Frequently Asked Questions</h2>
            <p className="text-gray-600">Quick answers to common questions</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="bg-white rounded-lg shadow-sm p-6">
              <h4 className="font-semibold text-gray-900 mb-2">What's your return policy?</h4>
              <p className="text-gray-600 text-sm">
                We offer a 30-day return policy for all products. Items must be in original condition with all accessories and packaging.
              </p>
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6">
              <h4 className="font-semibold text-gray-900 mb-2">Do you offer international shipping?</h4>
              <p className="text-gray-600 text-sm">
                Yes, we ship worldwide. Shipping costs and delivery times vary by location. Free shipping is available for orders over KES 100,000.
              </p>
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6">
              <h4 className="font-semibold text-gray-900 mb-2">What warranty do you provide?</h4>
              <p className="text-gray-600 text-sm">
                All our laptops come with a 3-year extended warranty covering hardware defects and technical support.
              </p>
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6">
              <h4 className="font-semibold text-gray-900 mb-2">Can I customize my laptop?</h4>
              <p className="text-gray-600 text-sm">
                Yes, many of our models offer customization options for RAM, storage, and other components. Contact our sales team for details.
              </p>
            </div>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default Contact;