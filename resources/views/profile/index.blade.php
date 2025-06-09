<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokenStore - Sua Loja de Gift Cards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #E5E7EB;
            background: linear-gradient(135deg, #0F0F0F 0%, #1A1A2E 50%, #16213E 100%);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1A1A2E 0%, #16213E 50%, #0F0F0F 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(186, 85, 211, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid #BA55D3;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #BA55D3;
            text-decoration: none;
            text-shadow: 0 0 10px rgba(186, 85, 211, 0.5);
        }

        .logo i {
            margin-right: 0.5rem;
            font-size: 2rem;
            color: #00BFFF;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: #E5E7EB;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: #BA55D3;
            text-shadow: 0 0 5px rgba(186, 85, 211, 0.5);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(90deg, #BA55D3, #00BFFF);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .search-container {
            position: relative;
            margin: 0 2rem;
        }

        .search-box {
            padding: 0.75rem 1rem;
            border: 2px solid #BA55D3;
            border-radius: 25px;
            width: 300px;
            font-size: 1rem;
            outline: none;
            background: rgba(26, 26, 46, 0.8);
            color: #E5E7EB;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: #00BFFF;
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
        }

        .search-box::placeholder {
            color: #9CA3AF;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }

        .btn-login {
            background: transparent;
            color: #BA55D3;
            border: 2px solid #BA55D3;
        }

        .btn-login:hover {
            background: #BA55D3;
            color: #0F0F0F;
            box-shadow: 0 0 15px rgba(186, 85, 211, 0.5);
        }

        .btn-register {
            background: linear-gradient(135deg, #BA55D3, #00BFFF);
            color: #0F0F0F;
            border: none;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #00BFFF, #BA55D3);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 191, 255, 0.4);
        }

        /* Carousel */
        .carousel-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto 3rem auto;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #1A1A2E 0%, #16213E 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .carousel-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(186, 85, 211, 0.3), rgba(0, 191, 255, 0.3));
        }

        .carousel-content {
            text-align: center;
            z-index: 2;
            position: relative;
            padding: 2rem;
        }

        .carousel-title {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #BA55D3, #00BFFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .carousel-subtitle {
            font-size: 1.3rem;
            color: #E5E7EB;
            margin-bottom: 2rem;
        }

        .carousel-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #BA55D3 0%, #00BFFF 100%);
            color: #0F0F0F;
            text-decoration: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(186, 85, 211, 0.4);
        }

        .carousel-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 191, 255, 0.6);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(26, 26, 46, 0.8);
            color: #BA55D3;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .carousel-nav:hover {
            background: rgba(186, 85, 211, 0.8);
            color: #0F0F0F;
            box-shadow: 0 0 15px rgba(186, 85, 211, 0.5);
        }

        .carousel-prev {
            left: 20px;
        }

        .carousel-next {
            right: 20px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(229, 231, 235, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: #BA55D3;
            box-shadow: 0 0 10px rgba(186, 85, 211, 0.7);
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
            min-height: calc(100vh - 200px);
        }

        .hero-section {
            text-align: center;
            margin-bottom: 4rem;
            background: rgba(26, 26, 46, 0.4);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 3rem;
            border: 2px solid rgba(186, 85, 211, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #BA55D3, #00BFFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #B0B7C3;
            margin-bottom: 2rem;
        }

        .hero-cta {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #BA55D3 0%, #00BFFF 100%);
            color: #0F0F0F;
            text-decoration: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(186, 85, 211, 0.4);
        }

        .hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 191, 255, 0.6);
            background: linear-gradient(135deg, #00BFFF 0%, #BA55D3 100%);
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: rgba(26, 26, 46, 0.4);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 2px solid rgba(186, 85, 211, 0.2);
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(26, 26, 46, 0.6);
            border-color: rgba(0, 191, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 191, 255, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            color: #00BFFF;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #BA55D3;
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #B0B7C3;
            line-height: 1.6;
        }

        /* Popular Games Section */
        .popular-games {
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #BA55D3, #00BFFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .game-card {
            background: rgba(26, 26, 46, 0.4);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid rgba(186, 85, 211, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .game-card:hover {
            transform: translateY(-5px);
            background: rgba(26, 26, 46, 0.6);
            border-color: rgba(0, 191, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 191, 255, 0.2);
        }

        .game-image {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #1A1A2E 0%, #16213E 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #00BFFF;
            text-shadow: 0 0 15px rgba(0, 191, 255, 0.7);
        }

        .game-info {
            padding: 1.5rem;
        }

        .game-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #E5E7EB;
            margin-bottom: 0.5rem;
        }

        .game-price {
            font-size: 1.1rem;
            color: #00BFFF;
            font-weight: 600;
            text-shadow: 0 0 5px rgba(0, 191, 255, 0.5);
        }

        /* Footer */
        .footer {
            background: rgba(15, 15, 15, 0.95);
            backdrop-filter: blur(15px);
            color: #E5E7EB;
            padding: 3rem 0 1rem;
            margin-top: auto;
            border-top: 2px solid rgba(186, 85, 211, 0.3);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #BA55D3;
            text-shadow: 0 0 5px rgba(186, 85, 211, 0.5);
        }

        .footer-section p {
            color: #B0B7C3;
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #B0B7C3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #00BFFF;
            text-shadow: 0 0 5px rgba(0, 191, 255, 0.5);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(26, 26, 46, 0.6);
            color: #B0B7C3;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid rgba(186, 85, 211, 0.3);
        }

        .social-link:hover {
            background: linear-gradient(135deg, #BA55D3, #00BFFF);
            color: #0F0F0F;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
        }

        .footer-bottom {
            text-align: center;
            padding: 2rem 0 1rem;
            border-top: 1px solid rgba(186, 85, 211, 0.3);
            margin-top: 2rem;
            color: #9CA3AF;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: #BA55D3;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-wrap: wrap;
                padding: 1rem;
            }

            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                margin-top: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-btn {
                display: block;
                order: 2;
            }

            .search-container {
                order: 3;
                width: 100%;
                margin: 1rem 0;
            }

            .search-box {
                width: 100%;
            }

            .auth-buttons {
                order: 4;
                width: 100%;
                justify-content: center;
            }

            .hero-title, .carousel-title {
                font-size: 2rem;
            }

            .hero-subtitle, .carousel-subtitle {
                font-size: 1.1rem;
            }

            .main-content {
                padding: 2rem 1rem;
            }

            .carousel-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .carousel-prev {
                left: 10px;
            }

            .carousel-next {
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <i class="fas fa-gamepad"></i>
                TokenStore
            </a>

            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="nav-links" id="navLinks">
                <a href="/">Home</a>
                <a href="/products">Produtos</a>
                <a href="/about">Sobre</a>
                <a href="/contact">Contato</a>
            </nav>
            
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Buscar jogos...">
            </div>
            
            <div class="auth-buttons">
                <!-- Para usuários não logados -->
                <a href="/login" class="btn btn-login">Login</a>
                <a href="/register" class="btn btn-register">Registrar</a>
                
                <!-- Para usuários logados (descomente quando implementar autenticação) -->
                <!-- 
                <a href="/dashboard" class="btn btn-login">Dashboard</a>
                <form method="POST" action="/logout" style="display: inline;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-register">Sair</button>
                </form>
                -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Carousel -->
        <div class="carousel-container">
            <div class="carousel" id="carousel">
                <div class="carousel-slide">
                    <div class="carousel-content">
                        <h2 class="carousel-title">Ofertas Especiais</h2>
                        <p class="carousel-subtitle">Até 50% de desconto em gift cards selecionados</p>
                        <a href="/products" class="carousel-btn">
                            <i class="fas fa-tags"></i> Ver Ofertas
                        </a>
                    </div>
                </div>
                <div class="carousel-slide">
                    <div class="carousel-content">
                        <h2 class="carousel-title">Entrega Instantânea</h2>
                        <p class="carousel-subtitle">Receba seus códigos imediatamente após a compra</p>
                        <a href="/products" class="carousel-btn">
                            <i class="fas fa-bolt"></i> Comprar Agora
                        </a>
                    </div>
                </div>
                <div class="carousel-slide">
                    <div class="carousel-content">
                        <h2 class="carousel-title">Suporte 24/7</h2>
                        <p class="carousel-subtitle">Nossa equipe está sempre pronta para ajudar você</p>
                        <a href="/contact" class="carousel-btn">
                            <i class="fas fa-headset"></i> Falar Conosco
                        </a>
                    </div>
                </div>
            </div>
            
            <button class="carousel-nav carousel-prev" onclick="prevSlide()">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-nav carousel-next" onclick="nextSlide()">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <div class="carousel-indicators">
                <span class="carousel-dot active" onclick="currentSlide(1)"></span>
                <span class="carousel-dot" onclick="currentSlide(2)"></span>
                <span class="carousel-dot" onclick="currentSlide(3)"></span>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="hero-section">
            <h1 class="hero-title">TokenStore</h1>
            <p class="hero-subtitle">A melhor loja para comprar gift cards digitais dos seus jogos favoritos</p>
            <a href="/products" class="hero-cta">
                <i class="fas fa-shopping-cart"></i> Explorar Produtos
            </a>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title">Entrega Instantânea</h3>
                <p class="feature-description">Receba seus códigos imediatamente após a compra, sem espera!</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">100% Seguro</h3>
                <p class="feature-description">Todos os códigos são originais e verificados antes da entrega.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="feature-title">Suporte 24/7</h3>
                <p class="feature-description">Nossa equipe está sempre pronta para ajudar você.</p>
            </div>
        </section>

        <!-- Popular Games Section -->
        <section class="popular-games">
            <h2 class="section-title">Jogos Populares</h2>
            <div class="games-grid">
                <div class="game-card" onclick="location.href='/products/1'">
                    <div class="game-image">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="game-info">
                        <h3 class="game-title">Fortnite V-Bucks</h3>
                        <p class="game-price">A partir de R$ 25,00</p>
                    </div>
                </div>
                
                <div class="game-card" onclick="location.href='/products/2'">
                    <div class="game-image">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="game-info">
                        <h3 class="game-title">Riot Points</h3>
                        <p class="game-price">A partir de R$ 20,00</p>
                    </div>
                </div>
                
                <div class="game-card" onclick="location.href='/products/3'">
                    <div class="game-image">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="game-info">
                        <h3 class="game-title">Steam Wallet</h3>
                        <p class="game-price">A partir de R$ 15,00</p>
                    </div>
                </div>
                
                <div class="game-card" onclick="location.href='/products/4'">
                    <div class="game-image">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="game-info">
                        <h3 class="game-title">Free Fire Diamantes</h3>
                        <p class="game-price">A partir de R$ 10,00</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>TokenStore</h3>
                <p>A melhor loja para comprar gift cards digitais dos seus jogos favoritos.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/products">Produtos</a></li>
                    <li><a href="/about">Sobre</a></li>
                    <li><a href="/contact">Contato</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="fas fa-envelope"></i> support@tokenstore.com</p>
                <p><i class="fas fa-phone"></i> (11) 99999-9999</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 TokenStore. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Carousel functionality
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            const carousel = document.getElementById('carousel');
            carousel.style.transform = `translateX(-${index * 100}%)`;
            
            // Update dots
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
            
            currentSlideIndex = index;
        }

        function nextSl