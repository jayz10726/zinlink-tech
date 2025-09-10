import React, { useEffect, useState } from 'react';
import { Users, Award, Clock, MapPin, Phone, Mail, CheckCircle, Star } from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import { apiService, ApiTeamMember } from '../services/api';

const About = () => {
  const navigate = useNavigate();
  const [teamMembers, setTeamMembers] = useState<ApiTeamMember[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchTeamMembers = async () => {
      try {
        const response = await apiService.getTeam();
        setTeamMembers(response.data);
        setLoading(false);
      } catch (err) {
        setError('Failed to load team members');
        setLoading(false);
      }
    };

    fetchTeamMembers();
  }, []);

  // Fallback team members if API fails
  const fallbackTeamMembers = [
    {
      name: "isaiah ndago",
      role: "Founder & Lead Technician",
      experience: "8+ years",
      specialty: "Chip-level repairs, Data Recovery"
    },
    {
      name: "onyango zeddy", 
      role: "Sales & Customer Relations",
      experience: "5+ years",
      specialty: "Product Consultation, Customer Support"
    },
    {
      name: "cctv technician team",
      role: "CCTV Specialist",
      experience: "6+ years", 
      specialty: "Security Systems, Network Setup"
    }
  ];

  const services = [
    {
      title: "Laptop & Desktop Sales",
      description: "Quality refurbished and new computers at competitive prices",
      icon: "💻"
    },
    {
      title: "Chip-Level Repairs",
      description: "Expert motherboard and component-level repairs",
      icon: "🔧"
    },
    {
      title: "Data Recovery",
      description: "Professional data recovery from all types of storage devices",
      icon: "💾"
    },
    {
      title: "CCTV Installation",
      description: "Complete security camera systems for homes and businesses",
      icon: "📹"
    },
    {
      title: "Hardware Upgrades",
      description: "RAM, SSD, and other component upgrades",
      icon: "⚡"
    },
    {
      title: "Software Solutions",
      description: "Operating system installation and software troubleshooting",
      icon: "🖥️"
    }
  ];

  const stats = [
    { number: "500+", label: "Happy Customers" },
    { number: "3+", label: "Years Experience" },
    { number: "1000+", label: "Devices Repaired" },
    { number: "50+", label: "CCTV Installations" }
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Hero Section */}
      <div className="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div className="container text-center">
          <h1 className="text-4xl md:text-6xl font-bold mb-6">
            About zinlink techs
          </h1>
          <p className="text-xl md:text-2xl opacity-90 max-w-4xl mx-auto leading-relaxed">
            Your trusted partner for professional computer solutions in Kisumu City. 
            We specialize in laptop repairs, sales, data recovery, and CCTV installations.
          </p>
        </div>
      </div>

      {/* Mission & Vision */}
      <div className="py-16">
        <div className="container">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Our Story
              </h2>
              <p className="text-lg text-gray-700 leading-relaxed mb-6">
                 Zinlinktech was Founded in December 2023 by Onyango Willis and Isaiah Ndago, Zinlink Tech is your trusted
                partner for all things computing. We specialize in laptop sales, professional repairs, and
                a wide selection of quality computer accessories.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed mb-6">
                At Zinlink Tech, our mission is simple: to make technology reliable, accessible, and affordable.
                Whether you're dealing with a slow system, looking to upgrade your gear, or need expert advice,
                we're here to help with honest service and real solutions.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed mb-6">
                Driven by a passion for tech and a commitment to customer satisfaction, we’re proud to serve
                students, professionals, and everyday users who rely on their devices to stay connected and productive.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed">
                Tech made easy. Service you can trust. Welcome to Zinlink Tech.
              </p>
            </div>
            <div className="bg-white rounded-2xl shadow-lg p-8">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Why Choose Us?</h3>
              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500" />
                  <span className="text-gray-700">Certified Technicians</span>
                </div>
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500" />
                  <span className="text-gray-700">Warranty on All Repairs</span>
                </div>
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500" />
                  <span className="text-gray-700">Competitive Pricing</span>
                </div>
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500" />
                  <span className="text-gray-700">Quick Turnaround Time</span>
                </div>
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500" />
                  <span className="text-gray-700">Local Support</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Stats */}
      <div className="bg-white py-16">
        <div className="container">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((stat, index) => (
              <div key={index} className="text-center">
                <div className="text-3xl md:text-4xl font-bold text-blue-600 mb-2">
                  {stat.number}
                </div>
                <div className="text-gray-600">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Services */}
      <div className="py-16">
        <div className="container">
          <h2 className="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-12">
            Our Services
          </h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {services.map((service, index) => (
              <div key={index} className="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <div className="text-4xl mb-4">{service.icon}</div>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">
                  {service.title}
                </h3>
                <p className="text-gray-600 leading-relaxed">
                  {service.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Team */}
      <div className="bg-gradient-to-br from-gray-50 to-white py-20">
        <div className="container">
          <div className="text-center mb-16">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
              Meet Our Expert Team
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Our certified technicians and professionals are dedicated to providing you with the best computer solutions and exceptional service.
            </p>
          </div>
          
          {loading ? (
            <div className="text-center py-16">
              <div className="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent mx-auto mb-6"></div>
              <p className="text-gray-500 text-lg font-medium">Loading our amazing team...</p>
            </div>
          ) : error ? (
            <div className="text-center py-16">
              <div className="bg-red-50 border border-red-200 rounded-2xl p-8 max-w-md mx-auto">
                <div className="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <svg className="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                  </svg>
                </div>
                <p className="text-red-600 text-lg font-semibold mb-2">{error}</p>
                <p className="text-gray-600">Showing fallback team information</p>
              </div>
            </div>
          ) : null}
          
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {(teamMembers.length > 0 ? teamMembers : fallbackTeamMembers).map((member, index) => {
              // Type guard to check if it's an API team member
              const isApiMember = 'photo_url' in member;
              
              return (
                <div key={index} className="group relative">
                  <div className="bgbg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    {/* Photo Section */}
                    <div className="relative h-64 bg-gradient-to-br from-blue-500 to-purple-600">
                      {isApiMember && member.photo_url ? (
                        <img 
                          src={member.photo_url} 
                          alt={member.name}
                          className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        />
                      ) : (
                        <div className="w-full h-full flex items-center justify-center">
                          <Users className="w-20 h-20 text-white opacity-80" />
                        </div>
                      )}
                      {/* Overlay gradient */}
                      <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                      
                      {/* Role badge */}
                      <div className="absolute bottom-4 left-4 right-4">
                        <span className="inline-block bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                          {member.role || 'Team Member'}
                        </span>
                      </div>
                    </div>
                    
                    {/* Content Section */}
                    <div className="p-6">
                      <h3 className="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300">
                        {member.name}
                      </h3>
                      
                      {isApiMember && member.bio ? (
                        <p className="text-gray-600 leading-relaxed mb-4 line-clamp-3">
                          {member.bio}
                        </p>
                      ) : !isApiMember ? (
                        <div className="space-y-2 mb-4">
                          <p className="text-sm text-gray-600">
                            <span className="font-semibold text-blue-600">{(member as any).experience}</span> experience
                          </p>
                          <p className="text-sm text-gray-500">
                            {(member as any).specialty}
                          </p>
                        </div>
                      ) : null}
                      
                      {/* Experience badge for API members */}
                      {isApiMember && (
                        <div className="flex items-center justify-center space-x-2 text-sm text-gray-500">
                          <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                          <span>Available for consultation</span>
                        </div>
                      )}
                    </div>
                    
                    {/* Hover effect border */}
                    <div className="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-blue-500 transition-colors duration-300 pointer-events-none"></div>
                  </div>
                </div>
              );
            })}
          </div>
          
          {/* Call to action */}
          <div className="text-center mt-16">
            <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
              <h3 className="text-2xl font-bold mb-4">Ready to Work With Our Team?</h3>
              <p className="text-blue-100 mb-6 max-w-2xl mx-auto">
                Our expert technicians are ready to help you with all your computer needs. 
                From repairs to installations, we've got you covered.
              </p>
              <button 
                onClick={() => navigate('/contact')}
                className="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-300 transform hover:scale-105"
              >
                Contact Us Today
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Contact Info */}
      <div className="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div className="container">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold mb-6">
                Get in Touch
              </h2>
              <p className="text-xl opacity-90 mb-8">
                Ready to experience our professional computer solutions? 
                Contact us today for a consultation or to schedule a service.
              </p>
              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <MapPin className="w-5 h-5" />
                  <span>Kisumu City, Kenya</span>
                </div>
                <div className="flex items-center space-x-3">
                  <Phone className="w-5 h-5" />
                  <span>0706850126</span>
                </div>
                <div className="flex items-center space-x-3">
                  <Mail className="w-5 h-5" />
                  <span>info@zinlink techs.com</span>
                </div>
              </div>
            </div>
            <div className="bg-white/20 backdrop-blur-sm rounded-2xl p-8">
              <h3 className="text-2xl font-bold mb-6">Business Hours</h3>
              <div className="space-y-3">
                <div className="flex justify-between">
                  <span>Monday - Friday</span>
                  <span>8:00 AM - 6:00 PM</span>
                </div>
                <div className="flex justify-between">
                  <span>Saturday</span>
                  <span>9:00 AM - 4:00 PM</span>
                </div>
                <div className="flex justify-between">
                  <span>Sunday</span>
                  <span>Closed</span>
                </div>
              </div>
              <div className="mt-6 pt-6 border-t border-white/30">
                <p className="text-sm opacity-90">
                  Emergency repairs available outside business hours
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default About; 
