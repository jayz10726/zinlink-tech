import React, { useState, useEffect } from 'react';
import { Star, Quote, User, Calendar, Plus, X } from 'lucide-react';
import { apiService, Review as ApiReview, CreateReviewData } from '../services/api';
import { motion } from 'framer-motion';

interface Review {
  id: number;
  name: string;
  rating: number;
  comment: string;
  date: string;
  service: string;
  avatar?: string;
}

const Reviews = () => {
  const [reviews, setReviews] = useState<Review[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const [showForm, setShowForm] = useState(false);
  const [newReview, setNewReview] = useState({
    name: '',
    rating: 5,
    comment: '',
    service: 'Laptop Repair'
  });

  const services = [
    'Laptop Repair',
    'CCTV Installation', 
    'Laptop Sales',
    'Data Recovery',
    'Consultation',
    'Hardware Upgrade',
    'Software Installation',
    'Network Setup'
  ];

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, i) => (
      <Star
        key={i}
        className={`w-5 h-5 ${
          i < rating ? 'text-yellow-400 fill-current' : 'text-gray-300'
        }`}
      />
    ));
  };

  // Load reviews from API
  useEffect(() => {
    const loadReviews = async () => {
      try {
        setLoading(true);
        const response = await apiService.getReviews();
        const apiReviews = response.data.map((apiReview: ApiReview) => ({
          id: apiReview.id,
          name: apiReview.customer_name,
          rating: apiReview.rating,
          comment: apiReview.comment,
          service: apiReview.service_used,
          date: new Date(apiReview.created_at).toISOString().split('T')[0]
        }));
        setReviews(apiReviews);
      } catch (err) {
        setError('Failed to load reviews');
        console.error('Error loading reviews:', err);
      } finally {
        setLoading(false);
      }
    };

    loadReviews();
  }, []);

  const handleSubmitReview = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!newReview.name.trim() || !newReview.comment.trim()) {
      alert('Please fill in all required fields');
      return;
    }

    try {
      const reviewData: CreateReviewData = {
        customer_name: newReview.name,
        service_used: newReview.service,
        rating: newReview.rating,
        comment: newReview.comment
      };

      await apiService.submitReview(reviewData);
      
      // Add the new review to the local state
      const review: Review = {
        id: Date.now(), // Temporary ID for display
        name: newReview.name,
        rating: newReview.rating,
        comment: newReview.comment,
        service: newReview.service,
        date: new Date().toISOString().split('T')[0]
      };

      setReviews([review, ...reviews]);
      setNewReview({
        name: '',
        rating: 5,
        comment: '',
        service: 'Laptop Repair'
      });
      setShowForm(false);
      
      alert('Review submitted successfully! It will be visible after admin approval.');
    } catch (err) {
      alert('Failed to submit review. Please try again.');
      console.error('Error submitting review:', err);
    }
  };

  const averageRating = reviews.reduce((acc, review) => acc + review.rating, 0) / reviews.length;
  const totalReviews = reviews.length;

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-12">
      <div className="container">
        {/* Header */}
        <motion.div className="text-center mb-12"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h1 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 drop-shadow-lg">
            Customer Reviews
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
            See what our satisfied customers have to say about our computer solutions and services in Kisumu
          </p>
          {/* Add Review Button */}
          <motion.button
            onClick={() => setShowForm(true)}
            className="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 hover:shadow-2xl transform hover:scale-105 focus:ring-2 focus:ring-blue-400"
            whileHover={{ scale: 1.07, boxShadow: '0 0 16px #6366f1' }}
            whileTap={{ scale: 0.97 }}
          >
            <Plus className="w-5 h-5 mr-2" />
            Add Your Review
          </motion.button>
        </motion.div>

        {/* Loading State */}
        {loading && (
          <div className="text-center py-12">
            <div className="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-800 bg-blue-100 rounded-lg">
              <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-800 mr-2"></div>
              Loading reviews...
            </div>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className="text-center py-12">
            <div className="inline-flex items-center px-4 py-2 text-sm font-medium text-red-800 bg-red-100 rounded-lg">
              <X className="w-4 h-4 mr-2" />
              {error}
            </div>
          </div>
        )}

        {/* Review Form Modal */}
        {showForm && (
          <motion.div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
          >
            <motion.div className="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
              initial={{ scale: 0.9, y: 40 }}
              animate={{ scale: 1, y: 0 }}
              transition={{ duration: 0.3 }}
            >
              <div className="p-8">
                <div className="flex items-center justify-between mb-6">
                  <h2 className="text-2xl font-bold text-gray-900">Add Your Review</h2>
                  <button
                    onClick={() => setShowForm(false)}
                    className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                  >
                    <X className="w-6 h-6" />
                  </button>
                </div>
                <form onSubmit={handleSubmitReview} className="space-y-6">
                  {/* Name */}
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Your Name *
                    </label>
                    <input
                      type="text"
                      value={newReview.name}
                      onChange={(e) => setNewReview({...newReview, name: e.target.value})}
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/70"
                      placeholder="Enter your name"
                      required
                    />
                  </div>
                  {/* Service */}
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Service Used *
                    </label>
                    <select
                      value={newReview.service}
                      onChange={(e) => setNewReview({...newReview, service: e.target.value})}
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/70"
                    >
                      {services.map((service) => (
                        <option key={service} value={service}>
                          {service}
                        </option>
                      ))}
                    </select>
                  </div>
                  {/* Rating */}
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Rating *
                    </label>
                    <div className="flex items-center space-x-2">
                      {[1, 2, 3, 4, 5].map((star) => (
                        <button
                          key={star}
                          type="button"
                          onClick={() => setNewReview({...newReview, rating: star})}
                          className="focus:outline-none"
                        >
                          <Star
                            className={`w-8 h-8 transition-transform duration-200 ${
                              star <= newReview.rating ? 'text-yellow-400 fill-current scale-110' : 'text-gray-300'
                            }`}
                          />
                        </button>
                      ))}
                      <span className="ml-2 text-sm text-gray-600">
                        {newReview.rating} out of 5
                      </span>
                    </div>
                  </div>
                  {/* Comment */}
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Your Review *
                    </label>
                    <textarea
                      value={newReview.comment}
                      onChange={(e) => setNewReview({...newReview, comment: e.target.value})}
                      rows={4}
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/70"
                      placeholder="Share your experience with our service..."
                      required
                    />
                  </div>
                  {/* Submit Button */}
                  <div className="flex space-x-4 pt-4">
                    <button
                      type="submit"
                      className="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300"
                    >
                      Submit Review
                    </button>
                    <button
                      type="button"
                      onClick={() => setShowForm(false)}
                      className="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-300 transition-all duration-300"
                    >
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </motion.div>
          </motion.div>
        )}

        {/* Overall Rating */}
        <motion.div className="bg-white/70 backdrop-blur-lg rounded-2xl shadow-2xl p-8 mb-12"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.2 }}
        >
          <div className="text-center">
            <div className="flex justify-center items-center space-x-2 mb-4">
              {renderStars(Math.round(averageRating))}
              <span className="text-2xl font-bold text-gray-900 ml-2">
                {averageRating.toFixed(1)}
              </span>
            </div>
            <p className="text-lg text-gray-600 mb-2">
              Based on {totalReviews} reviews
            </p>
            <div className="flex justify-center space-x-4 text-sm text-gray-500">
              <span>⭐ Excellent Service</span>
              <span>🔧 Professional Repairs</span>
              <span>💻 Quality Products</span>
            </div>
          </div>
        </motion.div>

        {/* Reviews Grid */}
        <motion.div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
          initial="hidden"
          animate="visible"
          variants={{
            hidden: {},
            visible: { transition: { staggerChildren: 0.08 } }
          }}
        >
          {reviews.map((review) => (
            <motion.div
              key={review.id}
              className="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-shadow duration-300 border border-blue-100"
              initial={{ opacity: 0, y: 40 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
            >
              {/* Review Header */}
              <div className="flex items-start justify-between mb-4">
                <div className="flex items-center space-x-3">
                  <motion.div
                    className="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg"
                    whileHover={{ scale: 1.1, rotate: 6 }}
                  >
                    <User className="w-6 h-6 text-white" />
                  </motion.div>
                  <div>
                    <h3 className="font-semibold text-gray-900">{review.name}</h3>
                    <p className="text-sm text-gray-500">{review.service}</p>
                  </div>
                </div>
                <div className="flex items-center space-x-1">
                  {renderStars(review.rating)}
                </div>
              </div>
              {/* Review Content */}
              <div className="mb-4">
                <Quote className="w-6 h-6 text-gray-400 mb-2 animate-pulse" />
                <p className="text-gray-700 leading-relaxed italic">
                  "{review.comment}"
                </p>
              </div>
              {/* Review Footer */}
              <div className="flex items-center justify-between text-sm text-gray-500">
                <div className="flex items-center space-x-1">
                  <Calendar className="w-4 h-4" />
                  <span>{new Date(review.date).toLocaleDateString()}</span>
                </div>
                <span className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                  {review.service}
                </span>
              </div>
            </motion.div>
          ))}
        </motion.div>

        {/* Call to Action */}
        <motion.div className="text-center mt-16"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.3 }}
        >
          <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-2xl">
            <h2 className="text-3xl font-bold mb-4">
              Ready to Experience Our Service?
            </h2>
            <p className="text-xl mb-6 opacity-90">
              Join our satisfied customers and get the best computer solutions in Kisumu
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <a
                href="/contact"
                className="inline-flex items-center px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 shadow-lg"
              >
                Contact Us
              </a>
              <a
                href="/products"
                className="inline-flex items-center px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-lg"
              >
                View Products
              </a>
            </div>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default Reviews; 