<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TokenStore - A melhor loja de gift cards digitais</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #8a2be2;
            --primary-cyan: #00ffff;
            --primary-magenta: #ff00ff;
            --dark-bg: #0a0a0a;
            --dark-secondary: #1a0a1a;
            --dark-tertiary: #0a0a1a;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            background:
                radial-gradient(circle at 20% 50%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 0, 255, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 50%, var(--dark-tertiary) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--primary-purple), var(--primary-magenta));
            border-radius: 4px;
        }

        .header {
            background: rgba(26, 10, 46, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1.2rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-magenta);
            text-decoration: none;
            position: relative;
            letter-spacing: -0.5px;
        }
        .logo::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--primary-magenta), var(--primary-cyan));
            border-radius: 8px;
            opacity: 0.15;
            z-index: -1;
        }
        .logo i {
            margin-right: 0.75rem;
            font-size: 2rem;
            color: var(--primary-cyan);
            filter: drop-shadow(0 0 4px rgba(0, 255, 255, 0.3));
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }
        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            padding: 0.5rem 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-magenta), var(--primary-cyan));
            transition: width 0.3s ease;
        }
        .nav-links a:hover {
            color: var(--text-primary);
            transform: translateY(-1px);
        }
        .nav-links a.active {
            color: var(--text-primary);
        }
        .nav-links a.active::after {
             width: 100%;
        }
        .nav-links a:hover::after {
            width: 100%;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon-left-submit {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            padding: 0.5rem;
            z-index: 2;
            line-height: 0;
        }

        .search-icon-left-submit:hover {
            color: var(--primary-cyan);
        }

        .search-box {
            padding: 0.875rem 1.25rem 0.875rem 3rem;
            width: 100%;
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            font-size: 0.95rem;
            outline: none;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .search-box::placeholder {
            color: var(--text-muted);
        }
        .search-box:focus {
            border-color: var(--primary-cyan);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            line-height: normal;
        }
        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .btn:hover::before {
            transform: translateX(100%);
        }
        .btn-login {
            background: transparent;
            color: var(--primary-magenta);
            border: 2px solid var(--primary-magenta);
        }
        .btn-login:hover {
            background: var(--primary-magenta);
            color: var(--dark-bg);
            box-shadow: 0 8px 25px rgba(255, 0, 255, 0.4);
            transform: translateY(-2px);
        }
        .btn-register {
            background: linear-gradient(135deg, var(--primary-purple) 0%, #4169e1 100%);
            color: white;
            border: 2px solid transparent;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #9932cc 0%, #4682b4 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(138, 43, 226, 0.5);
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            flex-grow: 1;
            width: 100%;
        }

        .hero-section {
            text-align: center;
            padding: 6rem 3rem;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle, rgba(0, 255, 255, 0.1) 0%, transparent 70%),
                radial-gradient(circle, rgba(255, 0, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
            z-index: -1;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-cyan) 0%, var(--primary-magenta) 50%, var(--primary-purple) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            position: relative;
        }
        .hero-subtitle {
            font-size: 1.4rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            font-weight: 400;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-cta {
            display: inline-flex;
            align-items: center;
            padding: 1.25rem 3rem;
            background: linear-gradient(135deg, var(--primary-magenta) 0%, var(--primary-purple) 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-cta i {
            margin-right: 0.8rem;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        .hero-cta:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255, 0, 255, 0.4);
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-cyan) 100%);
        }
        .hero-cta:hover i {
            transform: translateX(4px);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            border: 1px solid var(--glass-border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.6s;
        }
        .feature-card:hover::before {
            left: 100%;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .feature-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-magenta));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.3));
        }
        .feature-title {
            font-size: 1.5rem;
            color: var(--primary-magenta);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .feature-description {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .popular-games {
            margin-bottom: 4rem;
        }
        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, var(--primary-magenta) 0%, var(--primary-cyan) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .games-grid {
        }

        .game-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .game-card:hover {
            transform: translateY(-5px) scale(1.02);
            border-color: rgba(0, 255, 255, 0.4);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .game-image {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
        }

        .card-body.game-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding: 1.25rem;
            text-align: left;
        }

        .card-title.game-title {
            font-size: 1.1rem;
            color: var(--primary-magenta);
            margin-bottom: 0.75rem;
            font-weight: 600;
            line-height: 1.4;
            height: calc(1.1rem * 1.4 * 2);
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .card-text.game-description {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 1rem;
            height: calc(0.9rem * 1.5 * 3);
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .card-text.game-price {
            font-size: 1.1rem;
            color: var(--text-primary);
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
            text-align: right;
            padding-top: 0.5rem;
        }
        .game-card .btn-primary {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            width: 100%;
        }

        .footer {
            background:
                linear-gradient(135deg, rgba(10, 10, 10, 0.9) 0%, rgba(26, 10, 46, 0.9) 100%);
            backdrop-filter: blur(20px);
            color: white;
            padding: 4rem 0 2rem;
            margin-top: auto;
            border-top: 1px solid var(--glass-border);
            position: relative;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-cyan), var(--primary-magenta), transparent);
        }
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
            padding: 0 2rem;
        }
        .footer-section h3 {
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            color: var(--primary-magenta);
            font-weight: 700;
        }
        .footer-section p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .footer-links {
            list-style: none;
            padding-left: 0;
        }
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer-links a:hover {
            color: var(--primary-cyan);
            transform: translateX(4px);
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            justify-content: center;
        }
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            color: var(--text-secondary);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .social-link:hover {
            background: linear-gradient(135deg, var(--primary-magenta), var(--primary-cyan));
            color: white;
            transform: translateY(-3px);
            border-color: transparent;
            box-shadow: 0 8px 25px rgba(255, 0, 255, 0.3);
        }
        .footer-bottom {
            text-align: center;
            padding: 2rem 0 1rem;
            border-top: 1px solid var(--glass-border);
            margin-top: 3rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @media (max-width: 1024px) {
            .nav-container {
                padding: 0 1.5rem;
            }
            .search-box {
                width: 250px;
            }
        }
        @media (max-width: 991.98px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            .nav-links {
                flex-direction: column;
                align-items: center;
                width: 100%;
                gap: 1rem;
                margin-top: 1rem;
            }
            .search-container {
                width: 100%;
                max-width: 400px;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
            .search-box {
                width: 100%;
            }
            .auth-buttons {
                width: 100%;
                justify-content: center;
                margin-top: 1rem;
            }
        }
        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 1.5rem;
            }
            .hero-title {
                font-size: clamp(2rem, 6vw, 3.5rem);
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .main-content {
                padding: 2rem 1rem;
            }
            .features {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }
        }
        .demo-content {
            display: block;
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-gamepad"></i>
                TokenStore
            </a>
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">Inicio</a>
                <a href="{{ route('products.index') }}" class="{{ Route::is('products.index') ? 'active' : '' }}">Produtos</a>
                <a href="{{ route('cart.index') }}" class="{{ Route::is('cart.index') ? 'active' : '' }}">Carrinho</a>
                @auth
                    <a href="{{ route('account.index') }}" class="{{ Route::is('account.*') ? 'active' : '' }}">
                        Minha Conta
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.*') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Admin
                        </a>
                    @endif
                @endauth
            </nav>
           <form action="{{ route('products.search') }}" method="GET" class="search-container">
                <button type="submit" aria-label="Buscar" title="Buscar" class="search-icon-left-submit">
                    <i class="fas fa-search"></i>
                </button>
                <input type="text" name="query" class="search-box" placeholder="Procure por jogos..." value="{{ request('query') ?: request('search') }}">
            </form>
            <div class="auth-buttons">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Cadastre-se</a>
                @else
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-register">Sair</button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

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
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('products.index') }}">Produtos</a></li>
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Cadastre-se</a></li>
                    @else
                        {{-- ADICIONADO LINK MINHA CONTA AQUI TAMBÉM PARA CONSISTÊNCIA NO FOOTER --}}
                        <li><a href="{{ route('account.index') }}">Minha Conta</a></li>
                        <li><a href="{{ route('cart.index') }}">Carrinho</a></li>
                         @if(Auth::user()->is_admin)
                            <li><a href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                        @endif
                    @endguest
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="fas fa-envelope"></i> support@tokenstore.com</p>
                <p><i class="fas fa-phone"></i> (11) 99999-9999</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} TokenStore. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId.startsWith('#') && targetId.length > 1) {
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>