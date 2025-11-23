<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshFreeze - Solusi Terbaik untuk Bisnis Ikan Beku Anda</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #0c4a6e 0%, #0e7490 25%, #06b6d4 50%, #22d3ee 75%, #67e8f9 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Ice Crystals */
        .ice-crystal {
            position: fixed;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6) 0%, rgba(147, 197, 253, 0.3) 100%);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Fish Animation */
        .fish-swim {
            position: fixed;
            animation: swim 20s linear infinite;
            pointer-events: none;
            font-size: 60px;
            opacity: 0.3;
        }
        
        @keyframes swim {
            0% { transform: translateX(-100%) scaleX(1); }
            49% { transform: translateX(100vw) scaleX(1); }
            51% { transform: translateX(100vw) scaleX(-1); }
            100% { transform: translateX(-100%) scaleX(-1); }
        }
        
        /* Snowflakes */
        .snowflake {
            position: fixed;
            color: rgba(255, 255, 255, 0.8);
            font-size: 20px;
            animation: snowfall linear infinite;
            pointer-events: none;
        }
        
        @keyframes snowfall {
            0% { transform: translateY(-100%) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0.3; }
        }
        
        /* Header */
        header {
            padding: 24px 0;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #22d3ee, #2563eb);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 20px 40px rgba(34, 211, 238, 0.5);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .logo-text {
            font-size: 32px;
            font-weight: 900;
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
        }
        
        .nav-buttons {
            display: flex;
            gap: 12px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        
        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: white;
            color: #0891b2;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary:hover {
            background: #f0fdfa;
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        /* Hero Section */
        .hero {
            padding: 80px 0;
            position: relative;
            z-index: 10;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 60px;
            align-items: center;
        }
        
        @media (min-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .hero-content {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            color: #a5f3fc;
            font-weight: 600;
            font-size: 14px;
            width: fit-content;
            animation: pulse 3s ease-in-out infinite;
        }
        
        .hero-title {
            font-size: 56px;
            font-weight: 900;
            line-height: 1.2;
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
        }
        
        .hero-subtitle {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #a5f3fc, #67e8f9, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-description {
            font-size: 20px;
            line-height: 1.8;
            color: #e0f2fe;
            max-width: 600px;
        }
        
        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .btn-hero {
            padding: 16px 32px;
            font-size: 18px;
            font-weight: 700;
        }
        
        .btn-cta {
            background: white;
            color: #0891b2;
            box-shadow: 0 20px 40px rgba(34, 211, 238, 0.3);
        }
        
        .btn-cta:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 25px 50px rgba(34, 211, 238, 0.5);
        }
        
        /* Stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            padding-top: 32px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 900;
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
        }
        
        .stat-label {
            color: #bae6fd;
            font-weight: 600;
            margin-top: 8px;
        }
        
        /* Product Card */
        .product-card {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 32px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.3);
        }
        
        .product-image {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.3), rgba(37, 99, 235, 0.3));
            border-radius: 16px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            border: 2px solid rgba(34, 211, 238, 0.5);
            position: relative;
        }
        
        .product-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent);
            border-radius: 16px;
        }
        
        .fish-icon {
            font-size: 120px;
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .product-title {
            font-size: 24px;
            font-weight: 700;
        }
        
        .badge-fresh {
            background: #10b981;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }
        
        .product-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 20px 0;
            border-top: 1px solid rgba(34, 211, 238, 0.3);
            border-bottom: 1px solid rgba(34, 211, 238, 0.3);
            margin-bottom: 20px;
        }
        
        .product-stat {
            text-align: center;
        }
        
        .product-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #a5f3fc;
        }
        
        .product-stat-label {
            font-size: 12px;
            color: #bae6fd;
            margin-top: 4px;
        }
        
        .product-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .detail-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 12px;
        }
        
        .detail-label {
            font-size: 12px;
            color: #bae6fd;
        }
        
        .detail-value {
            font-weight: 700;
            margin-top: 4px;
        }
        
        .detail-value.green {
            color: #6ee7b7;
        }
        
        .detail-value.yellow {
            color: #fcd34d;
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 16px;
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
        }
        
        .section-subtitle {
            font-size: 20px;
            color: #e0f2fe;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        
        .feature-card {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(6, 182, 212, 0.3);
        }
        
        .feature-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .feature-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .feature-description {
            color: #e0f2fe;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        
        .feature-badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(34, 211, 238, 0.2);
            border-top: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 8px;
            font-size: 12px;
            color: #a5f3fc;
            font-weight: 600;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 80px 0;
        }
        
        .cta-card {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 0 60px rgba(34, 211, 238, 0.5);
            transition: all 0.3s ease;
        }
        
        .cta-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 80px rgba(34, 211, 238, 0.7);
        }
        
        .cta-title {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 24px;
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.8);
        }
        
        .cta-description {
            font-size: 20px;
            color: #e0f2fe;
            max-width: 800px;
            margin: 0 auto 32px;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }
        
        .cta-features {
            display: flex;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
            color: #bae6fd;
        }
        
        .cta-feature {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Footer */
        footer {
            padding: 40px 0;
            text-align: center;
            color: #bae6fd;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 40px;
            }
            
            .hero-subtitle {
                font-size: 24px;
            }
            
            .section-title {
                font-size: 36px;
            }
            
            .cta-title {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Background Effects -->
    <div class="ice-crystal" style="width: 10px; height: 10px; top: 10%; left: 10%; animation-delay: 0s;"></div>
    <div class="ice-crystal" style="width: 15px; height: 15px; top: 20%; left: 80%; animation-delay: 1s;"></div>
    <div class="ice-crystal" style="width: 8px; height: 8px; top: 60%; left: 15%; animation-delay: 2s;"></div>
    <div class="ice-crystal" style="width: 12px; height: 12px; top: 80%; left: 70%; animation-delay: 3s;"></div>
    <div class="ice-crystal" style="width: 18px; height: 18px; top: 40%; left: 90%; animation-delay: 1.5s;"></div>
    <div class="ice-crystal" style="width: 14px; height: 14px; top: 70%; left: 40%; animation-delay: 2.5s;"></div>
    
    <div class="fish-swim" style="top: 20%; animation-delay: 0s;">🐟</div>
    <div class="fish-swim" style="top: 40%; animation-delay: 5s;">🐠</div>
    <div class="fish-swim" style="top: 60%; animation-delay: 10s;">🐡</div>
    <div class="fish-swim" style="top: 80%; animation-delay: 15s;">🦈</div>
    
    <div class="snowflake" style="left: 5%; animation-duration: 15s; animation-delay: 0s;">❄</div>
    <div class="snowflake" style="left: 15%; animation-duration: 18s; animation-delay: 2s;">❅</div>
    <div class="snowflake" style="left: 25%; animation-duration: 20s; animation-delay: 4s;">❄</div>
    <div class="snowflake" style="left: 35%; animation-duration: 16s; animation-delay: 1s;">❆</div>
    <div class="snowflake" style="left: 45%; animation-duration: 19s; animation-delay: 3s;">❄</div>
    <div class="snowflake" style="left: 55%; animation-duration: 17s; animation-delay: 5s;">❅</div>
    <div class="snowflake" style="left: 65%; animation-duration: 21s; animation-delay: 2.5s;">❄</div>
    <div class="snowflake" style="left: 75%; animation-duration: 15s; animation-delay: 4.5s;">❆</div>
    <div class="snowflake" style="left: 85%; animation-duration: 18s; animation-delay: 1.5s;">❄</div>
    <div class="snowflake" style="left: 95%; animation-duration: 20s; animation-delay: 3.5s;">❅</div>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="nav-container">
                <div class="logo-container">
                    <div class="logo-icon">🐟</div>
                    <div class="logo-text">FreshFreeze</div>
                </div>
                <div class="nav-buttons">
                    <a href="{{ route('login') }}" class="btn btn-glass">Masuk</a>
                  
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="badge">
                        <span style="font-size: 18px;">❄️</span>
                        <span>Solusi Cold Storage Terpercaya #1 di Indonesia</span>
                    </div>
                    
                    <div>
                        <h1 class="hero-title">Revolusi Digital</h1>
                        <h2 class="hero-subtitle">Bisnis Ikan Beku</h2>
                        <h3 style="font-size: 28px; font-weight: 700; color: #bae6fd; margin-top: 16px;">Modern & Efisien</h3>
                    </div>
                    
                    <p class="hero-description">
                        Platform manajemen <strong>all-in-one</strong> untuk mengoptimalkan operasional bisnis ikan beku Anda. Dari stok hingga pengiriman, semua dalam <strong>satu sistem canggih</strong>.
                    </p>
                    
                    <div class="hero-buttons">
                        <a href="{{ route('register') }}" class="btn btn-cta btn-hero">🚀 Mulai Gratis</a>
                        <a href="#demo" class="btn btn-glass btn-hero">▶️ Lihat Demo</a>
                    </div>
                    
                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Produk</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">1K+</div>
                            <div class="stat-label">Pelanggan</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">99%</div>
                            <div class="stat-label">Puas</div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="product-card">
                        <div class="product-image">
                            <div class="fish-icon">🐟</div>
                        </div>
                        
                        <div class="product-header">
                            <h3 class="product-title">Tuna Sirip Kuning Premium</h3>
                            <span class="badge-fresh">FRESH</span>
                        </div>
                        
                        <div class="product-stats">
                            <div class="product-stat">
                                <div class="product-stat-value">1.2Kg</div>
                                <div class="product-stat-label">Berat</div>
                            </div>
                            <div class="product-stat">
                                <div class="product-stat-value">-18°C</div>
                                <div class="product-stat-label">Suhu</div>
                            </div>
                            <div class="product-stat">
                                <div class="product-stat-value">A+</div>
                                <div class="product-stat-label">Grade</div>
                            </div>
                        </div>
                        
                        <div class="product-details">
                            <div class="detail-item">
                                <div class="detail-label">Asal</div>
                                <div class="detail-value">Samudra Hindia</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Stok</div>
                                <div class="detail-value green">Tersedia</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Kadaluarsa</div>
                                <div class="detail-value">15 Des 2025</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Harga</div>
                                <div class="detail-value yellow">Rp 185K</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">Teknologi terdepan untuk bisnis ikan beku modern</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🏷️</div>
                    <h3 class="feature-title">Stok Real-Time</h3>
                    <p class="feature-description">Monitor inventori secara langsung dengan sistem otomatis dan alert cerdas</p>
                    <div class="feature-badge">✓ Update Otomatis</div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">❄️</div>
                    <h3 class="feature-title">Cold Storage</h3>
                    <p class="feature-description">Monitoring suhu 24/7 dengan notifikasi alert dan riwayat lengkap</p>
                    <div class="feature-badge">✓ Alert Suhu</div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3 class="feature-title">Analitik Pintar</h3>
                    <p class="feature-description">Dashboard analitik lengkap dengan insight bisnis dan prediksi trend</p>
                    <div class="feature-badge">✓ AI Powered</div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <h3 class="feature-title">Live Tracking</h3>
                    <p class="feature-description">Lacak pengiriman real-time hingga ke pelanggan dengan GPS akurat</p>
                    <div class="feature-badge">✓ GPS Tracking</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 class="cta-title">Siap Transformasi Bisnis Anda?</h2>
                <p class="cta-description">
                    Bergabunglah dengan ratusan bisnis ikan beku yang telah meningkatkan efisiensi dan profit mereka dengan FreshFreeze
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-cta btn-hero">🎉 Daftar Gratis Sekarang</a>
                    <a href="#features" class="btn btn-glass btn-hero">📚 Pelajari Lebih Lanjut</a>
                </div>
                <div class="cta-features">
                    <div class="cta-feature">
                        <span style="font-size: 24px;">✓</span>
                        <span>Gratis 30 hari</span>
                    </div>
                    <div class="cta-feature">
                        <span style="font-size: 24px;">✓</span>
                        <span>Tanpa kartu kredit</span>
                    </div>
                    <div class="cta-feature">
                        <span style="font-size: 24px;">✓</span>
                        <span>Support 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 FreshFreeze. Revolusi Bisnis Ikan Beku Indonesia.</p>
        </div>
    </footer>

</body>
</html>