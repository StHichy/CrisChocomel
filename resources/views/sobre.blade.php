<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sobre a loja | Cris Chocomel</title>
<meta name="description" content="A história da Cris Chocomel e o compromisso com ingredientes puros.">
<link rel="icon" type="image/png" href="{{ asset('favo-de-mel.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/sobre.css">
</head>
<body data-page="sobre">
<header class="site-nav">
  <div class="container d-flex flex-wrap align-items-center gap-2">
    <a class="brand" href="{{ route('index') }}" aria-label="Cris Chocomel, início">
      <svg class="brand-mark" viewBox="0 0 48 48" aria-hidden="true"><path d="M24 2l19 11v22L24 46 5 35V13z" fill="#E59E00"/><path d="M24 2l19 11v22L24 46 5 35V13z" fill="none" stroke="#2C1708" stroke-width="2"/><ellipse cx="24" cy="27" rx="9" ry="7.5" fill="#2C1708"/><path d="M19 22.5v9M24 21v12M29 22.5v9" stroke="#E59E00" stroke-width="2.6"/><ellipse cx="19" cy="17" rx="4.5" ry="6" fill="#FFF4DC" transform="rotate(-24 19 17)"/><ellipse cx="29" cy="17" rx="4.5" ry="6" fill="#FFF4DC" transform="rotate(24 29 17)"/></svg>
      <span><span class="brand-name">Cris <span>chocomel</span></span><span class="brand-sub">Doceria artesanal</span></span>
    </a>

    <nav class="collapse navbar-collapse d-lg-flex order-last order-lg-0 justify-content-lg-center" id="mainNav" aria-label="Principal">
      <ul class="navbar-nav gap-lg-1 py-2 py-lg-0">
        <li class="nav-item"><a class="nav-link" data-nav="index" href="{{ route('index') }}">Início</a></li>
        <li class="nav-item"><a class="nav-link" data-nav="produtos" href="{{ route('produtos') }}">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" data-nav="sobre" href="{{ route('sobre') }}">Sobre a loja</a></li>
        
        @guest
          <li class="nav-item"><a class="nav-link" data-nav="login" href="{{ route('login') }}">Entrar</a></li>
        @endguest

        @auth
          <li class="nav-item d-sm-none">
            <a class="nav-link" href="{{ route('profile.edit') }}">Meu Perfil ({{ explode(' ', auth()->user()->name)[0] }})</a>
          </li>
          <li class="nav-item d-sm-none">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link btn btn-link text-start text-danger">Sair</button>
            </form>
          </li>
        @endauth
      </ul>
    </nav>

    <div class="d-flex align-items-center gap-2 ms-auto ms-lg-0">
      <button class="icon-btn" id="themeBtn" type="button" aria-label="Alternar tema claro e escuro"></button>

      @auth
        <div class="dropdown d-none d-sm-inline-block">
          <button 
            class="acct dropdown-toggle bg-transparent border-0" 
            type="button" 
            id="userDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            Olá, <strong>{{ explode(' ', auth()->user()->name)[0] }}</strong>
          </button>

          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Meu Perfil</a></li>

            @if (auth()->user()->is_admin)
  <li><a class="dropdown-item" href="{{ route('admin.produtos') }}">Gerenciar Produtos</a></li>
@endif

            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Sair</button>
              </form>
            </li>
          </ul>
        </div>
      @endauth

      @guest
        <a class="acct d-none d-sm-inline-flex" href="{{ route('login') }}">Entrar</a>
      @endguest

      @php
        $totalItensSacola = collect(session('carrinho', []))->sum('quantidade');
      @endphp
      <a class="icon-btn cart" href="{{ route('carrinho') }}" aria-label="Abrir sacola">
        <span id="cartIcon"></span>
        @if ($totalItensSacola > 0)
          <span class="badge-count" style="display:flex">{{ $totalItensSacola }}</span>
        @endif
      </a>
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>
<main>
<div class="hero" style="padding-bottom:4rem">
    <div class="container position-relative" style="z-index:2">
      <span class="pill">Confeitaria afetiva desde o primeiro pão de mel</span>
      <h1 class="mt-3 mb-3">Nossa doce história e propósito</h1>
      <p class="lead-s">Como um sonho caseiro de levar afeto em forma de pão de mel se transformou na Cris Chocomel, conquistando centenas de famílias.</p>
    </div>
  </div>
  <div class="drip-wrap" aria-hidden="true"><svg class="drip-svg" viewBox="0 0 1200 110" preserveAspectRatio="xMidYMin meet"></svg></div>
  <div class="sec" style="padding-top:clamp(4rem,9vw,7rem)">
    <div class="container">
      <div class="row g-4 g-lg-5 align-items-center">
        <div class="col-lg-6 rv"><span class="eyebrow">Nosso começo</span><h2 class="mt-2 mb-3">O segredo do pão de mel perfeito</h2>
          <p class="lead-s mb-3">Tudo começou na pequena cozinha de casa, com o aroma de cravo, canela e mel silvestre fervendo em fogo brando.</p>
          <p class="muted">A Cris sempre acreditou que um doce nunca é apenas comida: é um abraço, uma memória de infância e uma demonstração genuína de carinho.</p></div>
        <div class="col-lg-6 rv"><div class="blob p-4"><div id="aboutArt2"></div></div></div>
      </div>
    </div>
  </div>
  <div class="sec sec-alt">
    <div class="container">
      <div class="sec-head rv"><div><span class="eyebrow">Compromisso inegociável</span><h2>Ingredientes puros e fornadas frescas</h2></div></div>
      <div class="row g-4" id="values"></div>
    </div>
  </div>
  <div class="sec">
    <div class="container"><div class="cta-band rv">
      <p class="quote mb-3">“Deus abençoe muito a todos!”</p>
      <p class="mb-4" style="color:var(--hero-muted)">Cris e equipe Chocomel</p>
      <div class="d-flex flex-wrap gap-3"><a class="btn btn-honey" href="{{ route('produtos') }}">Conhecer nossos sabores</a><a class="btn btn-hero-line wa-link" href="https://wa.me/" target="_blank" rel="noopener">Falar com a Cris</a></div>
    </div></div>
  </div>
</main>
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5"><a class="brand mb-3"<a href="{{ route('index') }}"><span class="brand-name">Cris <span>chocomel</span></span></a><p class="mb-0">Feito à mão com muito carinho. Pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.</p></div>
      <div class="col-6 col-md-3"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Navegue</h3><div class="d-grid gap-1"><a<a href="{{ route('index') }}">Início</a><a href="{{ route('produtos') }}">Produtos</a><a href="{{ route('sobre') }}">Sobre a loja</a><a href="{{ route('carrinho') }}">Sacola</a><a href="{{ route('login') }}">Entrar</a><a href="{{ route('register') }}">Criar conta</a></div></div>
      <div class="col-6 col-md-4"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Pedidos</h3><p>Confirmação pelo WhatsApp.</p><a class="btn btn-honey btn-sm wa-link" href="https://wa.me/15988081803" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <hr style="border-color:rgba(255,244,220,.18);margin-block:2rem 1rem"><p class="small mb-0">© 2026 Cris Chocomel. Todos os direitos reservados.</p>
  </div>
</footer>
<div class="toast-wrap" id="toasts" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="js/common.js"></script>
<script src="js/sobre.js"></script>
@include('partials.chocomel-alerts')
</body>
</html>
