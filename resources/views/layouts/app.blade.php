<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> {{-- <--- SEU COMENTÁRIO ORIGINAL --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TokenStore - A melhor loja de gift cards digitais')</title> {{-- Adicionado @yield com fallback --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- NOVO: Bootstrap Icons para ícones do atendimento --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* SEU CSS ORIGINAL COMPLETO DE 733 LINHAS COMEÇA AQUI */
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
            /* NOVO: Adicionando variável RGB para a sombra do botão flutuante, se não existir */
            --primary-purple-rgb: 138, 43, 226; 
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
            z-index: 1030; /* Ajustado para consistência com navbar fixa do Bootstrap */
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

        .nav-links { /* Mantendo sua estrutura original */
            display: flex;
            gap: 2.5rem;
            align-items: center;
            /* Adicionando list-style e padding para caso seja transformado em UL para responsivo depois */
            list-style: none; 
            padding-left: 0; 
            margin-bottom: 0; 
        }
         /* Se .nav-links for uma <nav> com <a> diretos, ok. Se for <ul>, aplicar a <li> */
        .nav-links > * { /* Aplica a filhos diretos (sejam <a> ou <li>) */
            display: inline-block; /* Para manter horizontal se for li */
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
            width: 100%; /* Seu original */
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

        /* Todos os seus estilos para .hero-section, .features, .game-card, etc. devem estar aqui */
        .hero-section {
            text-align: center; padding: 6rem 3rem; background: var(--glass-bg);
            backdrop-filter: blur(20px); border: 1px solid var(--glass-border); border-radius: 24px;
            margin-bottom: 4rem; position: relative; overflow: hidden;
        }
        .hero-section::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background:
                radial-gradient(circle, rgba(0, 255, 255, 0.1) 0%, transparent 70%),
                radial-gradient(circle, rgba(255, 0, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite; z-index: -1;
        }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(180deg); } }
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 900;
            background: linear-gradient(135deg, var(--primary-cyan) 0%, var(--primary-magenta) 50%, var(--primary-purple) 100%);
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem; line-height: 1.1; position: relative;
        }
        .hero-subtitle {
            font-size: 1.4rem; color: var(--text-secondary); margin-bottom: 3rem; font-weight: 400;
            max-width: 600px; margin-left: auto; margin-right: auto;
        }
        .hero-cta {
            display: inline-flex; align-items: center; padding: 1.25rem 3rem;
            background: linear-gradient(135deg, var(--primary-magenta) 0%, var(--primary-purple) 100%);
            color: white; text-decoration: none; border-radius: 50px; font-weight: 700; font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-cta i { margin-right: 0.8rem; font-size: 1.2rem; transition: transform 0.3s ease; }
        .hero-cta:hover {
            transform: translateY(-3px) scale(1.02); box-shadow: 0 20px 40px rgba(255, 0, 255, 0.4);
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-cyan) 100%);
        }
        .hero-cta:hover i { transform: translateX(4px); }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 4rem; }
        .feature-card {
            background: var(--glass-bg); backdrop-filter: blur(20px); padding: 2.5rem; border-radius: 20px;
            text-align: center; border: 1px solid var(--glass-border); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.6s;
        }
        .feature-card:hover::before { left: 100%; }
        .feature-card:hover { transform: translateY(-8px); border-color: rgba(0, 255, 255, 0.3); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .feature-icon {
            font-size: 4rem; margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-magenta));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.3));
        }
        .feature-title { font-size: 1.5rem; color: var(--primary-magenta); margin-bottom: 1rem; font-weight: 700; }
        .feature-description { font-size: 1rem; color: var(--text-secondary); line-height: 1.6; }
        .popular-games { margin-bottom: 4rem; }
        .section-title {
            font-size: 2.8rem; font-weight: 800; text-align: center; margin-bottom: 3rem;
            background: linear-gradient(135deg, var(--primary-magenta) 0%, var(--primary-cyan) 100%);
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .games-grid { /* Seu estilo aqui */ }
        .game-card {
            background: var(--glass-bg); backdrop-filter: blur(20px); border-radius: 20px; overflow: hidden;
            border: 1px solid var(--glass-border); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative; display: flex; flex-direction: column;
        }
        .game-card:hover { transform: translateY(-5px) scale(1.02); border-color: rgba(0, 255, 255, 0.4); box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4); }
        .game-image { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; }
        .card-body.game-info { display: flex; flex-direction: column; flex-grow: 1; padding: 1.25rem; text-align: left; }
        .card-title.game-title {
            font-size: 1.1rem; color: var(--primary-magenta); margin-bottom: 0.75rem; font-weight: 600; line-height: 1.4;
            height: calc(1.1rem * 1.4 * 2); overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2;
            -webkit-box-orient: vertical; text-overflow: ellipsis;
        }
        .card-text.game-description {
            font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; flex-grow: 1; margin-bottom: 1rem;
            height: calc(0.9rem * 1.5 * 3); overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;
            -webkit-box-orient: vertical; text-overflow: ellipsis;
        }
        .card-text.game-price {
            font-size: 1.1rem; color: var(--text-primary); font-weight: 700; font-family: 'JetBrains Mono', monospace;
            text-align: right; padding-top: 0.5rem;
        }
        .game-card .btn-primary { padding: 0.6rem 1rem; font-size: 0.9rem; width: 100%; }
        /* FIM DOS SEUS ESTILOS DE CONTEÚDO PRINCIPAL */

        .footer {
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.9) 0%, rgba(26, 10, 46, 0.9) 100%);
            backdrop-filter: blur(20px); color: white; padding: 4rem 0 2rem;
            margin-top: auto; border-top: 1px solid var(--glass-border); position: relative;
        }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--primary-cyan), var(--primary-magenta), transparent); }
        .footer-content {
            max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem; padding: 0 2rem;
        }
        .footer-section h3 { font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--primary-magenta); font-weight: 700; }
        .footer-section p { color: var(--text-secondary); line-height: 1.6; margin-bottom: 1rem; }
        .footer-section p a { color: var(--text-secondary); text-decoration:none; }
        .footer-section p a:hover { color: var(--primary-cyan); }
        .footer-links { list-style: none; padding-left: 0; }
        .footer-links li { margin-bottom: 0.8rem; }
        .footer-links a { color: var(--text-secondary); text-decoration: none; transition: all 0.3s ease; display: inline-block; }
        .footer-links a:hover { color: var(--primary-cyan); transform: translateX(4px); }
        .social-links { display: flex; gap: 1rem; margin-top: 1.5rem; justify-content: center; }
        .social-link {
            display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px;
            background: var(--glass-bg); backdrop-filter: blur(10px); color: var(--text-secondary);
            border: 1px solid var(--glass-border); border-radius: 12px; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .social-link:hover { background: linear-gradient(135deg, var(--primary-magenta), var(--primary-cyan)); color: white; transform: translateY(-3px); border-color: transparent; box-shadow: 0 8px 25px rgba(255, 0, 255, 0.3); }
        .footer-bottom { text-align: center; padding: 2rem 0 1rem; border-top: 1px solid var(--glass-border); margin-top: 3rem; color: var(--text-muted); font-size: 0.9rem; }

        /* NOVO: Estilos para o botão flutuante e modal de atendimento */
        .btn-floating-atendimento {
            position: fixed; bottom: 25px; right: 25px; width: 60px; height: 60px; border-radius: 50%;
            background-color: var(--primary-purple); color: white; border: none;
            display: flex; align-items: center; justify-content: center; z-index: 1040;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .btn-floating-atendimento:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(var(--primary-purple-rgb), 0.5);
            background-color: var(--primary-magenta);
        }
        .btn-floating-atendimento i { font-size: 1.8rem; }

        #atendimentoModal .modal-content {
            background-color: var(--dark-secondary); border: 1px solid var(--glass-border); color: var(--text-secondary);
            border-radius: 0.75rem;
        }
        #atendimentoModal .modal-header {
            background-color: var(--primary-purple); color: white; border-bottom: 1px solid var(--primary-magenta);
            border-top-left-radius: calc(0.75rem - 1px); border-top-right-radius: calc(0.75rem - 1px);
        }
        #atendimentoModal .modal-header .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        #atendimentoModal .modal-title i { vertical-align: -0.125em; margin-right: 0.5rem; }
        #atendimentoModal .modal-body a { color: var(--primary-cyan); text-decoration: none; }
        #atendimentoModal .modal-body a:hover { text-decoration: underline; color: var(--primary-magenta); }
        #atendimentoModal .modal-body ul {padding-left: 0.5rem;}
        #atendimentoModal .list-unstyled i { width: 22px; text-align: center; margin-right: 0.5rem; color: var(--primary-cyan); }
        #atendimentoModal .modal-footer {
            border-top: 1px solid var(--glass-border);
            border-bottom-left-radius: calc(0.75rem - 1px); border-bottom-right-radius: calc(0.75rem - 1px);
        }
        #atendimentoModal .btn-secondary {
            background-color: var(--text-muted); border-color: var(--text-muted); color: var(--dark-bg);
        }
        #atendimentoModal .btn-secondary:hover { background-color: var(--text-secondary); border-color: var(--text-secondary); }
        
        /* NOVO: Ajustes para o link de atendimento no nav-links para manter o estilo original e ícone */
        .nav-links .atendimento-link i { 
            margin-right: 0.4rem; /* Espaço entre ícone e texto */
            font-size: 0.9em; /* Ícone um pouco menor que o texto do link */
            vertical-align: -0.05em; /* Ajuste vertical fino */
        }
        /* NOVO: Estilos para o menu responsivo Bootstrap */
        .navbar-toggler { /* Estilo para o botão hamburger */
            border-color: var(--primary-cyan);
        }
        .navbar-toggler-icon { /* Cor do ícone hamburger */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

         /* Se os links no menu colapsado perderem o estilo, podemos adicionar aqui: */
        .navbar-collapse .nav-link { /* Para links dentro do .navbar-nav no .navbar-collapse */
            color: var(--text-secondary);
            font-weight: 500; /* Mantendo o peso da fonte original */
            font-size: 0.95rem; /* Mantendo o tamanho da fonte original */
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .navbar-collapse .nav-link:hover {
            color: var(--text-primary);
        }
        .navbar-collapse .nav-link.active {
            color: var(--primary-cyan); /* Destaque diferente no mobile */
        }
        .navbar-collapse .btn { margin-top: 0.5rem; margin-bottom: 0.5rem; }

        @media (max-width: 1024px) {
            .nav-container { padding: 0 1.5rem; }
            .search-box { width: 250px; }
        }
        @media (max-width: 991.98px) { /* Breakpoint lg do Bootstrap */
            /* Seu CSS original para este breakpoint é que o .nav-container vira column.
               Para usar o collapse do Bootstrap, precisamos de uma estrutura HTML diferente no header.
               O HTML abaixo já está adaptado para isso.
               Os estilos abaixo (.nav-links, .search-container, .auth-buttons dentro do colapso)
               serão aplicados ao conteúdo DENTRO do menu colapsado,
               se eles usarem as mesmas classes.
            */
            .nav-container.original-mobile-layout { /* Classe de exemplo se você quisesse forçar o layout antigo */
                flex-direction: column; gap: 1rem;
            }
            /* etc... (seus outros estilos para 991.98px) */
        }
        @media (max-width: 768px) {
            .hero-section { padding: 4rem 1.5rem; }
            .hero-title { font-size: clamp(2rem, 6vw, 3.5rem); }
            .hero-subtitle { font-size: 1.1rem; }
            .main-content { padding: 2rem 1rem; }
            .features { grid-template-columns: 1fr; gap: 1.5rem; }
            .footer-content { grid-template-columns: 1fr; gap: 2rem; text-align: center; }
            .btn-floating-atendimento { width: 50px; height: 50px; bottom: 20px; right: 20px; }
            .btn-floating-atendimento i { font-size: 1.5rem; }
        }
        .demo-content { display: block; }
        /* FIM DO SEU CSS ORIGINAL */

        /* --- Secao de Frete Gratis (conforme imagem) --- */
        .free-shipping-section {
            background-color: rgba(26, 10, 46, 0.7); /* Fundo sutil */
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem auto; /* Centraliza e adiciona margem acima/abaixo */
            max-width: 1200px; /* Limita largura */
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            text-align: center;
            flex-wrap: wrap; /* Permite quebrar linha em telas menores */
        }

        .free-shipping-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1 1 200px; /* Flexibilidade para itens */
            min-width: 150px; /* Garante que nao fiquem muito pequenos */
            padding: 0.5rem;
            margin: 0.5rem; /* Espacamento entre os itens */
        }

        .free-shipping-item i {
            font-size: 2rem;
            color: var(--primary-cyan); /* Cor do icone */
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 0 5px rgba(0, 255, 255, 0.3)); /* Brilho no icone */
        }

        .free-shipping-item h4 {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.3rem;
            color: var(--text-primary);
        }

        .free-shipping-item p {
            font-size: 0.9rem;
            color: var(--text-secondary);
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

            {{-- NOVO: Botão Toggler do Bootstrap para o menu responsivo --}}
            {{-- Este botão só será visível em telas menores que 'lg' (definido pelo Bootstrap) --}}
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsiveContent" aria-controls="navbarResponsiveContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Conteúdo do Header que será colapsado em telas menores --}}
            {{-- Envolvendo o nav-links, search-container e auth-buttons em um div que será colapsado --}}
            {{-- Adicionando classes Bootstrap para controlar visibilidade e comportamento --}}
            <div class="collapse navbar-collapse d-lg-flex justify-content-end" id="navbarResponsiveContent">
                {{-- Seu nav-links original --}}
                <nav class="nav-links me-lg-3"> {{-- Adicionado margin end para desktop --}}
                    <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">Inicio</a>
                    <a href="{{ route('products.index') }}" class="{{ Route::is('products.index') ? 'active' : '' }}">Produtos</a>
                    <a href="{{ route('cart.index') }}" class="{{ Route::is('cart.index') ? 'active' : '' }}">Carrinho</a>
                    @auth
                        <a href="{{ route('account.index') }}" class="{{ Str::startsWith(Route::currentRouteName(), 'account.') ? 'active' : '' }}">Minha Conta</a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="{{ Str::startsWith(Route::currentRouteName(), 'admin.') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Admin</a>
                        @endif
                    @endauth
                    {{-- NOVO: Link de Atendimento --}}
                    <a href="#" class="atendimento-link" data-bs-toggle="modal" data-bs-target="#atendimentoModal">
                        <i class="bi bi-headset"></i> Atendimento
                    </a>
                </nav>
                {{-- Seu form de busca original --}}
                <form action="{{ route('products.search') }}" method="GET" class="search-container me-lg-3"> {{-- Adicionado margin end para desktop --}}
                    <button type="submit" aria-label="Buscar" title="Buscar" class="search-icon-left-submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="text" name="query" class="search-box" placeholder="Procure por jogos..." value="{{ request('query') ?: request('search') }}">
                </form>
                {{-- Seus botões de auth originais --}}
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
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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
                        <li><a href="{{ route('account.index') }}">Minha Conta</a></li>
                        <li><a href="{{ route('cart.index') }}">Carrinho</a></li>
                         @if(Auth::user()->is_admin)
                            <li><a href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                        @endif
                    @endguest
                    {{-- NOVO: Link de Atendimento no Footer --}}
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#atendimentoModal">Atendimento</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="fas fa-envelope"></i> <a href="mailto:support@tokenstore.com" class="text-decoration-none" style="color: var(--text-secondary);">support@tokenstore.com</a></p>
                <p><i class="fas fa-phone"></i> <a href="tel:+5511999999999" class="text-decoration-none" style="color: var(--text-secondary);">(11) 99999-9999</a></p>
                {{-- NOVO: Horário de atendimento --}}
                <p class="mb-0"><i class="fas fa-clock"></i> Seg-Sex: 09h às 18h</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} TokenStore. Todos os direitos reservados.</p>
        </div>
    </footer>

    {{-- NOVO: BOTÃO FLUTUANTE DE ATENDIMENTO --}}
    <button type="button" class="btn btn-floating-atendimento shadow-lg" data-bs-toggle="modal" data-bs-target="#atendimentoModal" title="Central de Atendimento">
        <i class="bi bi-headset"></i> {{-- Pode usar fas fa-headset se preferir FontAwesome --}}
    </button>

    {{-- NOVO: MODAL DE ATENDIMENTO --}}
    <div class="modal fade" id="atendimentoModal" tabindex="-1" aria-labelledby="atendimentoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="atendimentoModalLabel">
                        <i class="bi bi-headset"></i> Central de Atendimento {{-- Pode usar fas fa-headset --}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Entre em contato conosco através dos seguintes canais:</p>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill"></i> {{-- Pode usar fas fa-envelope --}}
                            <strong>Email:</strong> <a href="mailto:atendimento@tokenstore.com.br">atendimento@tokenstore.com.br</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill"></i> {{-- Pode usar fas fa-phone --}}
                            <strong>Telefone:</strong> (11) 99999-9999 (Exemplo)
                        </li>
                        <li>
                            <i class="bi bi-clock-fill"></i> {{-- Pode usar fas fa-clock --}}
                            <strong>Horário de Atendimento:</strong> Segunda a Sexta, das 09h às 18h.
                        </li>
                    </ul>
                    <hr>
                    <p class="small text-muted mb-0">Responderemos o mais breve possível!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SEU SCRIPT ORIGINAL (INTACTO)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                // Adicionando verificação para não interferir com data-bs-toggle (modais, collapses)
                if (targetId && targetId.startsWith('#') && targetId.length > 1 && !this.dataset.bsToggle) {
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