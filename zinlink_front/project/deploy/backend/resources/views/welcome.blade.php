<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>zinlink tech</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                margin: 0;
                padding: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                text-align: center;
                background: white;
                padding: 3rem;
                border-radius: 1rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: 2rem;
            }
            h1 {
                color: #1a202c;
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .tagline {
                color: #4a5568;
                font-size: 1.25rem;
                margin-bottom: 2rem;
            }
            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                margin-top: 2rem;
            }
            .feature {
                padding: 1.5rem;
                background: #f7fafc;
                border-radius: 0.5rem;
                border-left: 4px solid #667eea;
            }
            .feature h3 {
                color: #2d3748;
                margin-bottom: 0.5rem;
            }
            .feature p {
                color: #718096;
                font-size: 0.9rem;
            }
            .cta-button {
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 1rem 2rem;
                border-radius: 0.5rem;
                text-decoration: none;
                font-weight: 600;
                margin-top: 2rem;
                transition: background 0.3s ease;
            }
            .cta-button:hover {
                background: #5a67d8;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>zinlink tech</h1>
            <p class="tagline">Your trusted partner for laptop sales, repairs, and technical support</p>
            
            <div class="features">
                <div class="feature">
                    <h3>🛒 Sales</h3>
                    <p>Premium laptops and accessories for all your computing needs</p>
                </div>
                <div class="feature">
                    <h3>🔧 Repairs</h3>
                    <p>Expert repair services for all laptop brands and models</p>
                </div>
                <div class="feature">
                    <h3>💻 Support</h3>
                    <p>Professional technical support and maintenance services</p>
                </div>
            </div>
            
            <a href="#" class="cta-button">Get Started Today</a>
        </div>
    </body>
</html>
