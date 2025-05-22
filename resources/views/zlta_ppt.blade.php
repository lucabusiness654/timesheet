<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend Progress Report – Last 6 Months</title>
    <style>
        :root {
            --primary: #2b3a67;
            --secondary: #496a81;
            --accent: #66999b;
            --light: #b3af8f;
            --highlight: #ffc482;
            --text: #333;
            --bg: #f5f7fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--bg);
            color: var(--text);
            overflow: hidden;
        }
        
        .presentation {
            width: 100vw;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            padding: 40px;
            background-color: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 5px;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.5s ease-in-out;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        
        .slide.active {
            transform: translateX(0);
            opacity: 1;
            z-index: 10;
        }
        
        .slide.prev {
            transform: translateX(-100%);
            opacity: 0;
        }
        
        .slide.next {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .slide-title {
            color: var(--primary);
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 700;
            border-bottom: 3px solid var(--accent);
            padding-bottom: 10px;
            display: inline-block;
            position: relative;
        }
        
        .slide-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 50%;
            height: 3px;
            background-color: var(--highlight);
        }
        
        .slide-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* Title slide */
        #title-slide {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        
        #title-slide .slide-title {
            color: white;
            border-bottom-color: var(--highlight);
            font-size: 3.5rem;
            margin-bottom: 20px;
            animation: titleFadeIn 1s ease-out;
        }
        
        #title-slide .subtitle {
            font-size: 1.5rem;
            opacity: 0;
            animation: subtitleFadeIn 1s ease-out 0.5s forwards;
        }
        
        /* Table slide */
        .table-container {
            width: 100%;
            overflow: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: var(--primary);
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e9e9e9;
        }
        
        /* Feature grid */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .feature-category {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-left: 4px solid var(--accent);
            transform: translateY(20px);
            opacity: 0;
        }
        
        .feature-category h3 {
            color: var(--primary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .feature-list {
            list-style-type: none;
        }
        
        .feature-list li {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Process flow */
        .process-flow {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60%;
            position: relative;
        }
        
        .process-step {
            background-color: var(--primary);
            color: white;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: absolute;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            opacity: 0;
            transform: scale(0.5);
        }
        
        .process-arrow {
            position: absolute;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            opacity: 0;
        }
        
        /* Thank you slide */
        #thank-you-slide {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        
        #thank-you-slide .slide-title {
            color: white;
            border-bottom: none;
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        #thank-you-slide .subtitle {
            font-size: 1.8rem;
            max-width: 70%;
            line-height: 1.5;
        }
        
        /* Navigation controls */
        .nav-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        
        .nav-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s;
        }
        
        .nav-btn:hover {
            background-color: var(--secondary);
            transform: scale(1.1);
        }
        
        /* Animations */
        @keyframes titleFadeIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes subtitleFadeIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .slide {
                padding: 20px;
            }
            
            .slide-title {
                font-size: 1.8rem;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="presentation">
        <!-- Slide 1: Title Slide -->
        <div class="slide active" id="title-slide">
            <h1 class="slide-title">Backend Progress Report</h1>
            <p class="subtitle">Last 6 Months</p>
        </div>
        
        <!-- Slide 3: Monthly Release Summary -->
        <div class="slide" id="monthly-release">
            <h2 class="slide-title">📊 Monthly Release Summary</h2>
            <div class="slide-content">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Releases</th>
                                <th>Major</th>
                                <th>Minor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dec 2023</td>
                                <td>2</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Jan 2024</td>
                                <td>2</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Feb 2024</td>
                                <td>2</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>March 2024</td>
                                <td>7</td>
                                <td>5</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>April 2024</td>
                                <td>3</td>
                                <td>3</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>May 2024</td>
                                <td>4</td>
                                <td>3</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Slide 4: Key Features & Enhancements -->
        <div class="slide" id="key-features">
            <h2 class="slide-title">🚀 Feature Enhancements by Category</h2>
            <div class="slide-content">
                <div class="feature-grid">
                    <div class="feature-category fade-in delay-1">
                        <h3>🛒 Order Placement</h3>
                        <ul class="feature-list">
                            <li>Normal Order</li>
                            <li>Exchange/Return/Cancel</li>
                            <li>RTO Handling</li>
                            <li>Order Delay</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-2">
                        <h3>🎮 Gamification</h3>
                        <ul class="feature-list">
                            <li>Catch & Win Dress</li>
                            <li>Love Meter</li>
                            <li>Pac-Man (Glam grabe)</li>
                            <li>Spin Wheel</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-3">
                        <h3>🚚 Courier</h3>
                        <ul class="feature-list">
                            <li>Delivery</li>
                            <li>AK Express</li>
                            <li>Shiprocket</li>
                            <li>I Think Logistics</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-4">
                        <h3>🎁 Rewards</h3>
                        <ul class="feature-list">
                            <li>Gift wrapping</li>
                            <li>Gift Cards</li>
                            <li>Threads</li>
                            <li>Donates</li>
                            <li>Coupons</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-5">
                        <h3>📹 Media</h3>
                        <ul class="feature-list">
                            <li>Vimeo</li>
                            <li>Cloudinary</li>
                            <li>CloudFront (CDN)</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-1">
                        <h3>🧩 Size Module</h3>
                        <ul class="feature-list">
                            <li>Combo (Top & Bottom)</li>
                            <li>Custom Sizes</li>
                            <li>Accessories</li>
                            <li>Single (Top)</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-2">
                        <h3>🔍 SEO</h3>
                        <ul class="feature-list">
                            <li>Dynamic Sitemap</li>
                            <li>Tags</li>
                            <li>Schema</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-3">
                        <h3>💬 Notifications</h3>
                        <ul class="feature-list">
                            <li>AI Sensy (WhatsApp Notification)</li>
                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-4">
                        <h3>💳 Offers</h3>
                        <ul class="feature-list">
                            <li>Buy1 Get1</li>
                            <li>Buy1 Get1 at 1 Rs</li>
                            <li>Buy 1 Get 2nd product 50% off</li>
                            <li>Buy 2 @ 999</li>
                            <li>Buy2 and Buy3 Offer</li>
                            <li>Special Promotional Price</li>
                            <li>Get Flat Offer</li>

                        </ul>
                    </div>
                    <div class="feature-category fade-in delay-5">
                        <h3>🧪 New Modules</h3>
                        <ul class="feature-list">
                            <li>Early Access</li>
                            <li>Offline Expo Sale</li>
                            <li>Launch Popups</li>
                            <li>Wishlist</li>
                            <li>Ask us anything</li>
                            <li>Media library in admin panel</li>
                            <li>Search keyword</li>
                            <li>Wishlist - New layout</li>
                            <li>Export popup in admin panel</li>
                            <li>Express delivery option</li>
                            <li>Multiple sale at once</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 5: Backend Optimization Efforts -->
        <div class="slide" id="optimization">
            <h2 class="slide-title">⚙️ Backend Optimization Initiatives</h2>
            <div class="slide-content">
                <ul class="feature-list" style="font-size: 1.2rem;">
                    <li class="fade-in delay-1">SQL Query Optimization and indexing</li>
                    <li class="fade-in delay-2">Laravel v10 upgrade</li>
                    <li class="fade-in delay-3">Modular service classes</li>
                    <li class="fade-in delay-4">TypeSense Caching Implementation</li>
                    <li class="fade-in delay-5">SEO Automation</li>
                    <li class="fade-in delay-1">Image compression and Handling</li>
                </ul>
            </div>
        </div>
        
        <!-- Slide 6: Third-Party Integrations -->
        <div class="slide" id="integrations">
            <h2 class="slide-title">🌐 Integrated External Services</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                    <div class="fade-in delay-1" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Inventory</h3>
                        <p>Zoho Inventory</p>
                    </div>
                    <div class="fade-in delay-2" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Media</h3>
                        <p>Cloudinary</p>
                    </div>
                    <div class="fade-in delay-3" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Courier</h3>
                        <p>AK Express</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Analytics</h3>
                        <p>GA4 API</p>
                    </div>
                    <div class="fade-in delay-5" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Ads</h3>
                        <p>Google Ads</p>
                    </div>
                    <div class="fade-in delay-1" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>E-commerce</h3>
                        <p>Google Merchant</p>
                    </div>
                    <div class="fade-in delay-2" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Social</h3>
                        <p>Facebook Pixel</p>
                    </div>
                    <div class="fade-in delay-3" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Search</h3>
                        <p>TypeSense</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Utilities</h3>
                        <p>Stape.io</p>
                    </div>
                    <div class="fade-in delay-5" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>APIs</h3>
                        <p>RapidAPI</p>
                    </div>
                    <div class="fade-in delay-1" style="background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <h3>Location</h3>
                        <p>Postalpincode</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 7: Marketing & SEO Support -->
        <div class="slide" id="marketing-seo">
            <h2 class="slide-title">📣 Technical Support for Marketing</h2>
            <div class="slide-content">
                <div style="display: flex; justify-content: center; margin-top: 30px;">
                    <div style="position: relative; width: 80%; height: 300px;">
                        <div style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; padding: 20px; border-radius: 8px; width: 150px; text-align: center; opacity: 0;" class="fade-in delay-1">
                            Backend
                        </div>
                        <div style="position: absolute; left: 200px; top: 50%; transform: translateY(-50%); background: var(--accent); color: white; padding: 20px; border-radius: 8px; width: 150px; text-align: center; opacity: 0;" class="fade-in delay-2">
                            Data
                        </div>
                        <div style="position: absolute; left: 400px; top: 50%; transform: translateY(-50%); background: var(--secondary); color: white; padding: 20px; border-radius: 8px; width: 150px; text-align: center; opacity: 0;" class="fade-in delay-3">
                            Marketing Tools
                        </div>
                    </div>
                </div>
                <div style="margin-top: 50px;">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Implemented Features:</h3>
                    <ul class="feature-list" style="columns: 2; column-gap: 40px;">
                        <li class="fade-in delay-1">Schema</li>
                        <li class="fade-in delay-2">Sitemap</li>
                        <li class="fade-in delay-3">Micro Page Campaign microsites</li>
                        <li class="fade-in delay-4">GA4 API integration (Client side)</li>
                        <li class="fade-in delay-5">Google Ads (Client side)</li>
                        <li class="fade-in delay-1">Google merchant (Server side)</li>
                        <li class="fade-in delay-2">Facebook Conversion (Server side)</li>
                        <li class="fade-in delay-3">Facebook Pixel (Client side)</li>
                        <li class="fade-in delay-4">TypeSense for Search (in testing)</li>
                        <li class="fade-in delay-5">GA4 API integration self Host, Stape, GCP (Server side)</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Slide 8: Server-Side Handling -->
        <div class="slide" id="server-side">
            <h2 class="slide-title">🖥️ Server-Side Architecture & Optimization</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                    <div class="fade-in delay-1" style="background: #f5f5f5; padding: 20px; border-radius: 8px; border-left: 4px solid var(--accent);">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">Hosting</h3>
                        <p>Web + Queue servers on dedicated hosting</p>
                    </div>
                    <div class="fade-in delay-2" style="background: #f5f5f5; padding: 20px; border-radius: 8px; border-left: 4px solid var(--accent);">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">Content Management</h3>
                        <p>Blog & redirect management</p>
                    </div>
                    <div class="fade-in delay-3" style="background: #f5f5f5; padding: 20px; border-radius: 8px; border-left: 4px solid var(--accent);">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">Analytics</h3>
                        <p>Self-hosted GA API</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #f5f5f5; padding: 20px; border-radius: 8px; border-left: 4px solid var(--accent);">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">Email</h3>
                        <p>SES Email & spam filtering</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 9: Workflows & Process -->
        <div class="slide" id="workflows">
            <h2 class="slide-title">📈 Agile-Driven Backend Workflows</h2>
            <div class="slide-content">
                <div class="process-flow">
                    <div class="process-step fade-in" style="top: 50%; left: 10%; transform: translate(-50%, -50%); animation-delay: 0.1s;">Requirement</div>
                    <div class="process-step fade-in" style="top: 20%; left: 30%; transform: translate(-50%, -50%); animation-delay: 0.5s;">Sprint Planning</div>
                    <div class="process-step fade-in" style="top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 0.9s;">Development</div>
                    <div class="process-step fade-in" style="top: 80%; left: 70%; transform: translate(-50%, -50%); animation-delay: 1.3s;">Testing</div>
                    <div class="process-step fade-in" style="top: 50%; left: 90%; transform: translate(-50%, -50%); animation-delay: 1.7s;">Deploy</div>
                </div>
            </div>
        </div>
        
        <!-- Slide 10: Team Development -->
        <div class="slide" id="team-dev">
            <h2 class="slide-title">👨‍💻 Team Growth & Knowledge Sharing</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                    <div class="fade-in delay-1" style="background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">🎯 Bi-weekly sessions</h3>
                        <p>Regular knowledge sharing and updates</p>
                    </div>
                    <div class="fade-in delay-2" style="background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">🎓 Udemy access</h3>
                        <p>Continuous learning opportunities</p>
                    </div>
                    <div class="fade-in delay-3" style="background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">🏅 Internal awards</h3>
                        <p>Recognition for outstanding work</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="color: var(--primary); margin-bottom: 10px;">🔄 Knowledge transfer</h3>
                        <p>Cross-team collaboration</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 11: Ongoing Challenges -->
        <div class="slide" id="challenges">
            <h2 class="slide-title">🚧 Key Backend Challenges</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px; margin-top: 20px;">
                    <div class="fade-in delay-1" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Tight deadlines</h3> -->
                        <p>Continuous releases leave little room for learning and skill development.​</p>
                    </div>
                    <div class="fade-in delay-2" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Misuse of features</h3> -->
                        <p>In many cases, clients do not use the requested features after implementation. Later,
                            they often return with new requirements for the same sections, leading to
                            unnecessary rework.</p>
                    </div>
                    <div class="fade-in delay-3" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Overwork during launches</h3> -->
                        <p>A significant number of issues arise due to clients not using the system correctly or
                            lacking proper understanding of its functionalities.</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Lack of early clarity</h3> -->
                        <p>Developer suggestions for improvements or optimizations are often not accepted
                            initially. However, the same ideas are later requested again, causing avoidable
                            delays and rework.</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Lack of early clarity</h3> -->
                        <p>The team frequently works extended hours to ensure tasks are completed on time for
                            each release.</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Lack of early clarity</h3> -->
                        <p>Recently, we received requests for monthly reports that include individual records for
                            each user and each date. This has proven to be difficult and time-consuming to
                            manage efficiently. As a result, we are spending a significant amount of time on
                            documentation and reporting, leaving little room to focus on team growth and
                            strategic improvements.</p>
                    </div>
                    <div class="fade-in delay-4" style="background: #fff4e6; padding: 15px; border-radius: 8px; border-left: 4px solid #ffa500;">
                        <!-- <h3 style="color: var(--primary); margin-bottom: 5px;">Lack of early clarity</h3> -->
                        <p>Sometimes, we get urgent tasks without proper documents or clear details. After
                            discussing with the team, we find out that the task needs more time and is not
                            actually urgent. It would be better if the client talks to the team before planning the
                            launch, but this is not happening now.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 12: Proposed Solutions -->
        <div class="slide" id="solutions">
            <h2 class="slide-title">💡 Proposed Solutions & Recommendations</h2>
            <div class="slide-content">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Challenge</th>
                                <!-- <th>Solution</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="fade-in delay-1">
                                <td>Requesting buffer periods between releases for upgrades</td>
                                <!-- <td>Add release buffers</td> -->
                            </tr>
                            <tr class="fade-in delay-2">
                                <td>Proposal to switch frontend better framework</td>
                                <!-- <td>Discuss feasibility earlier</td> -->
                            </tr>
                            <tr class="fade-in delay-3">
                                <td>Better alignment between client expectation vs feasibility</td>
                                <!-- <td>Demos/training for clients</td> -->
                            </tr>
                            <tr class="fade-in delay-4">
                                <td>Requesting to provide some offers for developers to purchase products from Zlaata</td>
                                <!-- <td>Zlaata perks or rewards</td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Slide 13: Production Issues & Handling -->
        <div class="slide" id="production-issues">
            <h2 class="slide-title">🔥 Common Production Issues & Fix Approach</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
                    <div class="fade-in delay-1" style="text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">📷</div>
                        <h3>Image loading</h3>
                    </div>
                    <div class="fade-in delay-2" style="text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">📥</div>
                        <h3>Export issues</h3>
                    </div>
                    <div class="fade-in delay-3" style="text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">🐌</div>
                        <h3>Page lag</h3>
                    </div>
                    <div class="fade-in delay-4" style="text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">💳</div>
                        <h3>Payment mismatch</h3>
                    </div>
                    <div class="fade-in delay-5" style="text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px;">✉️</div>
                        <h3>Email spam</h3>
                    </div>
                </div>
                <div style="margin-top: 50px; text-align: center;">
                    <h3 style="color: var(--primary); margin-bottom: 20px;">Fix Path:</h3>
                    <div style="display: flex; justify-content: center; align-items: center; gap: 30px;">
                        <div class="fade-in delay-1" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 20px; min-width: 100px; text-align: center;">
                            Fix
                        </div>
                        <div class="fade-in delay-2" style="background: var(--accent); color: white; padding: 10px 20px; border-radius: 20px; min-width: 100px; text-align: center;">
                            Staging Validation
                        </div>
                        <div class="fade-in delay-3" style="background: var(--secondary); color: white; padding: 10px 20px; border-radius: 20px; min-width: 100px; text-align: center;">
                            Deploy
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 14: Functional Elements on All Pages -->
        <div class="slide" id="functional-elements">
            <h2 class="slide-title">📄 Common Page-Level Functionalities</h2>
            <div class="slide-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                    <div class="fade-in delay-1" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">Dynamic rendering</h3>
                    </div>
                    <div class="fade-in delay-2" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">Offer timers</h3>
                    </div>
                    <div class="fade-in delay-3" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">GA/FB Pixel</h3>
                    </div>
                    <div class="fade-in delay-4" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">Sliders</h3>
                    </div>
                    <div class="fade-in delay-5" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">SEO schema</h3>
                    </div>
                    <div class="fade-in delay-1" style="background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4682b4;">
                        <h3 style="color: var(--primary);">Keyword tracking</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 17: Thank You -->
        <div class="slide" id="thank-you-slide">
            <h1 class="slide-title">Thank You 🙏</h1>
            <p class="subtitle">Dedicated efforts shaping Zlaata's backend success</p>
        </div>
        
        <!-- Navigation controls -->
        <div class="nav-controls">
            <button class="nav-btn" id="prev-btn">←</button>
            <button class="nav-btn" id="next-btn">→</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentSlide = 0;
            
            // Initialize first slide
            showSlide(currentSlide);
            
            // Next button click handler
            nextBtn.addEventListener('click', function() {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    showSlide(currentSlide);
                }
            });
            
            // Previous button click handler
            prevBtn.addEventListener('click', function() {
                if (currentSlide > 0) {
                    currentSlide--;
                    showSlide(currentSlide);
                }
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    nextBtn.click();
                } else if (e.key === 'ArrowLeft') {
                    prevBtn.click();
                }
            });
            
            // Show specific slide
            function showSlide(index) {
                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.classList.add('active');
                        slide.classList.remove('prev', 'next');
                        
                        // Trigger animations for elements in the current slide
                        const animElements = slide.querySelectorAll('.fade-in');
                        animElements.forEach(el => {
                            el.style.animationPlayState = 'running';
                        });
                    } else if (i < index) {
                        slide.classList.remove('active', 'next');
                        slide.classList.add('prev');
                    } else {
                        slide.classList.remove('active', 'prev');
                        slide.classList.add('next');
                    }
                });
                
                // Update button states
                prevBtn.disabled = currentSlide === 0;
                nextBtn.disabled = currentSlide === slides.length - 1;
            }
            
            // Preload animations by setting initial state
            document.querySelectorAll('.fade-in').forEach(el => {
                el.style.animationPlayState = 'paused';
            });
        });
    </script>
</body>
</html>