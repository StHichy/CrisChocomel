<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrar | Cris Chocomel</title>
<meta name="description" content="Entre na sua conta Cris Chocomel.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body data-page="login">
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
        
        <!-- Só aparece se NÃO estiver logado -->
        @guest
          <li class="nav-item"><a class="nav-link" data-nav="login" href="{{ route('login') }}">Entrar</a></li>
        @endguest

        <!-- Só aparece se ESTIVER logado (opcional: link de sair no menu mobile) -->
        @auth
          <li class="nav-item d-sm-none">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link btn btn-link text-start">Sair ({{ explode(' ', auth()->user()->name)[0] }})</button>
            </form>
          </li>
        @endauth
      </ul>
    </nav>

    <div class="d-flex align-items-center gap-2 ms-auto ms-lg-0">
      <button class="icon-btn" id="themeBtn" type="button" aria-label="Alternar tema claro e escuro"></button>

      <!-- Se estiver LOGADO: mostra o primeiro nome e botão de Sair -->
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
      <li>
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          Meu Perfil
        </a>
      </li>

      {{-- Opcional: atalho rápido se o usuário for admin --}}
      @if (auth()->user()->is_admin)
        <li>
          <a class="dropdown-item" href="{{ route('produtos.create') }}">
            + Novo Produto
          </a>
        </li>
      @endif

      <li><hr class="dropdown-divider"></li>

      <li>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
          @csrf
          <button type="submit" class="dropdown-item text-danger">
            Sair
          </button>
        </form>
      </li>
    </ul>
  </div>
@endauth

      <!-- Se NÃO estiver logado: mostra o botão padrão de login -->
      @guest
        <a class="acct d-none d-sm-inline-flex" href="{{ route('login') }}">Entrar</a>
      @endguest

      <a class="icon-btn cart" href="{{ route('carrinho') }}" aria-label="Abrir sacola">
        <span id="cartIcon"></span>
        <span class="badge-count" id="cartCount">0</span>
      </a>
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>
<main>
<section>
  <div class="sec">
    <div class="container">
      <div class="row g-4 g-lg-5 align-items-stretch">
        <div class="col-lg-5">
          <div class="cta-band h-100 auth-side">
            <div>
              <span class="pill mb-3">Seu cantinho doce</span>
              <h2 class="mb-3">Bem-vindo de volta ao nosso cantinho doce</h2>
              <p style="color:var(--hero-muted)">Tenha acesso a cupons, salve seus dados de entrega e receba avisos das novas fornadas de pão de mel.</p>
              <ul class="perks"><li><span data-i="check"></span><span>10% de desconto no primeiro pedido</span></li><li><span data-i="check"></span><span>Acompanhamento do pedido pelo WhatsApp</span></li><li><span data-i="check"></span><span>Acesso prioritário em Natal e Páscoa</span></li></ul>
            </div>
            <div class="blob d-none d-lg-block mx-auto" style="width:58%;padding:1rem"><div id="authArt"></div></div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="panel" id="authBox">
            <div class="auth-switch"><a class="on" href="{{ route('login') }}" aria-current="page">Já tenho conta</a><a href="{{ route('register') }}">Criar nova conta</a></div>
            <!-- 1. Exibir mensagens de erro de login (ex: "Essas credenciais não correspondem...") -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Status da sessão (ex: após resetar senha) -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<!-- 2. Aponte o action para route('login') e garanta method="POST" -->
<form method="POST" action="{{ route('login') }}">
    <!-- 3. Token de segurança obrigatório do Laravel -->
    @csrf

    <!-- 4. Campo de E-mail: garanta name="email" e value="{{ old('email') }}" -->
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-control @error('email') is-invalid @enderror" 
            value="{{ old('email') }}" 
            required 
            autofocus
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- 5. Campo de Senha: garanta name="password" -->
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control @error('password') is-invalid @enderror" 
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- 6. Lembrar-me (opcional, caso tenha no seu layout) -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label" for="remember_me">Lembrar de mim</label>
    </div>

    <!-- 7. Botão de envio: precisa ser type="submit" -->
    <button type="submit" class="btn btn-honey w-100">Entrar</button>
</form>
            <p class="small muted mt-4 mb-0">Esta é uma versão de demonstração: nome e preferências ficam apenas neste navegador e a senha não é guardada.</p>
          </div>
          <div class="panel" id="loggedBox" hidden>
            <span class="eyebrow">Minha conta</span>
            <h2 class="mt-2 mb-2" id="loggedName"></h2>
            <p class="muted">Você está dentro. Seu cupom de boas-vindas já pode ser usado na sacola.</p>
            <div class="logged-code"><strong class="display">BEMVINDA10</strong><span class="muted">10% de desconto no pedido</span></div>
            <div class="d-flex flex-wrap gap-3"><a class="btn btn-honey" href="{{ route('produtos') }}">Escolher doces</a><button class="btn btn-line" id="logoutBtn" type="button">Sair da conta</button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5"><a class="brand mb-3"<a href="{{ route('index') }}"><span class="brand-name">Cris <span>chocomel</span></span></a><p class="mb-0">Feito à mão com muito carinho. Pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.</p></div>
      <div class="col-6 col-md-3"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Navegue</h3><div class="d-grid gap-1"><a<a href="{{ route('index') }}">Início</a><a href="{{ route('produtos') }}">Produtos</a><a href="{{ route('sobre') }}">Sobre a loja</a><a href="{{ route('carrinho') }}">Sacola</a><a href="{{ route('login') }}">Entrar</a><a href="{{ route('register') }}">Criar conta</a></div></div>
      <div class="col-6 col-md-4"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Pedidos</h3><p>Confirmação pelo WhatsApp.</p><a class="btn btn-honey btn-sm wa-link" href="https://wa.me/" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <hr style="border-color:rgba(255,244,220,.18);margin-block:2rem 1rem"><p class="small mb-0">© 2026 Cris Chocomel. Todos os direitos reservados.</p>
  </div>
</footer>
<div class="toast-wrap" id="toasts" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="js/common.js"></script>
<script src="js/login.js"></script>
</body>
</html>
