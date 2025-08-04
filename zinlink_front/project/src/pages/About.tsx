import React from 'react';
import { Users, Award, Clock, MapPin, Phone, Mail, CheckCircle, Star } from 'lucide-react';

const About = () => {
  const teamMembers = [
    {
      name: "George smart",
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
                zinlink techs was founded in 2019 with a simple mission: to provide reliable, 
                affordable, and professional computer services to the people of Kisumu City and surrounding areas.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed mb-6">
                What started as a small repair shop has grown into a comprehensive computer solutions center, 
                offering everything from chip-level laptop repairs to complete CCTV security systems.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed mb-6">
                Located in the heart of Kisumu City at Wananchi Plaza, we've built our reputation on trust, 
                quality workmanship, and exceptional customer service. Our team of certified technicians brings 
                years of experience and a passion for technology to every project.
              </p>
              <p className="text-lg text-gray-700 leading-relaxed">
                Today, we're proud to be the go-to destination for computer sales, repairs, and technical 
                services in Kisumu, serving hundreds of satisfied customers including students, professionals, 
                and businesses.
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
      <div className="bg-white py-16">
        <div className="container">
          <h2 className="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-12">
            Our Team
          </h2>
          <div className="grid md:grid-cols-3 gap-8">
            {teamMembers.map((member, index) => (
              <div key={index} className="bg-gray-50 rounded-xl p-6 text-center">
                <div className="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Users className="w-10 h-10 text-white" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-2">
                  {member.name}
                </h3>
                <p className="text-blue-600 font-medium mb-2">{member.role}</p>
                <p className="text-sm text-gray-600 mb-3">{member.experience} experience</p>
                <p className="text-sm text-gray-500">{member.specialty}</p>
              </div>
            ))}
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