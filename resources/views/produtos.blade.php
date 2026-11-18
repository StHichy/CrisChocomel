<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Produtos | Cris Chocomel</title>
<meta name="description" content="Cardápio de pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">
<link rel="stylesheet" href="{{ asset('css/produtos.css') }}">
</head>
<body data-page="produtos">

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
  <div class="page-head">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <span class="eyebrow">Menu artesanal</span>
          <h1 class="mt-2 mb-3">Nossos doces feitos à mão</h1>
        </div>

        @if (auth()->check() && auth()->user()->is_admin)
          <a href="{{ route('produtos.create') }}" class="btn btn-honey">+ Novo Produto</a>
        @endif
      </div>

      <p class="lead-s mb-4">Escolha por categoria, adicione à sacola e feche seu pedido ou monte sua caixa personalizada.</p>

      <form method="GET" action="{{ route('produtos') }}" class="row g-3 align-items-center">
        <div class="col-lg-7">
          <div class="chips" role="group" aria-label="Categorias">
            <a href="{{ route('produtos', request()->except('categoria')) }}" 
               class="chip text-decoration-none" 
               aria-pressed="{{ !request('categoria') ? 'true' : 'false' }}">
               Todos os doces
            </a>
            @foreach (\App\Models\Categoria::orderBy('nome')->get() as $cat)
              <a href="{{ route('produtos', array_merge(request()->query(), ['categoria' => $cat->slug])) }}" 
                 class="chip text-decoration-none" 
                 aria-pressed="{{ request('categoria') === $cat->slug ? 'true' : 'false' }}">
                 {{ $cat->nome }}
              </a>
            @endforeach
          </div>
        </div>

        @if (request('categoria'))
          <input type="hidden" name="categoria" value="{{ request('categoria') }}">
        @endif

        <div class="col-lg-3 col-sm-7">
          <label class="visually-hidden" for="q">Buscar doce</label>
          <input class="form-control" id="q" name="busca" type="search" value="{{ request('busca') }}" placeholder="Buscar doce…" autocomplete="off">
        </div>

        <div class="col-lg-2 col-sm-5">
          <label class="visually-hidden" for="sort">Ordenar</label>
          <select class="form-select" id="sort" name="ordem" onchange="this.form.submit()">
            <option value="rel" {{ request('ordem') === 'rel' ? 'selected' : '' }}>Destaques</option>
            <option value="asc" {{ request('ordem') === 'asc' ? 'selected' : '' }}>Menor preço</option>
            <option value="desc" {{ request('ordem') === 'desc' ? 'selected' : '' }}>Maior preço</option>
            <option value="az" {{ request('ordem') === 'az' ? 'selected' : '' }}>A a Z</option>
          </select>
        </div>
      </form>
    </div>
  </div>

  <div class="sec pt-4">
    <div class="container">
      @if ($produtos->isEmpty())
        <div class="empty">
          <h3>Nenhum doce encontrado</h3>
          <p>Tente outra palavra ou volte para todas as categorias.</p>
          <a href="{{ route('produtos') }}" class="btn btn-line btn-sm">Limpar filtros</a>
        </div>
      @else
        <div class="row g-4" id="grid">
          @foreach ($produtos as $index => $produto)
            <div class="col-6 col-lg-3">
              <article class="pcard" style="--i:{{ $index }}">
                <div class="art">
                  @if ($produto->imagem)
<img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">                  @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                      Sem foto
                    </div>
                  @endif

                  @if ($produto->destaque)
                    <span class="tag">Destaque</span>
                  @elseif ($produto->categoria)
                    <span class="tag">{{ ucfirst($produto->categoria) }}</span>
                  @endif
                </div>

                <div class="pbody">
                  <h2 class="pname h5 mb-1">{{ $produto->nome }}</h2>
                  <p class="pdesc">{{ $produto->descricao }}</p>

                  <div class="pfoot">
                    <span class="price">R${{ number_format($produto->preco, 2, ',', '.') }}</span>
                    
                    <button 
                      type="button" 
                      class="btn btn-honey btn-sm btn-abrir-sacola"
                      data-url="{{ route('carrinho.adicionar', $produto->id) }}"
                      data-nome="{{ $produto->nome }}"
                      data-preco="{{ $produto->preco }}"
                      data-imagem="{{ $produto->imagem }}"
                    >
                      <span data-i="plus"></span> Sacola
                    </button>
                  </div>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5"><a class="brand mb-3" href="{{ route('index') }}"><span class="brand-name">Cris <span>chocomel</span></span></a><p class="mb-0">Feito à mão com muito carinho. Pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.</p></div>
      <div class="col-6 col-md-3"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Navegue</h3><div class="d-grid gap-1"><a href="{{ route('index') }}">Início</a><a href="{{ route('produtos') }}">Produtos</a><a href="{{ route('sobre') }}">Sobre a loja</a><a href="{{ route('carrinho') }}">Sacola</a>@guest<a href="{{ route('login') }}">Entrar</a><a href="{{ route('register') }}">Criar conta</a>@endguest</div></div>
      <div class="col-6 col-md-4"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Pedidos</h3><p>Confirmação pelo WhatsApp.</p><a class="btn btn-honey btn-sm wa-link" href="https://wa.me/" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <hr style="border-color:rgba(255,244,220,.18);margin-block:2rem 1rem"><p class="small mb-0">© 2026 Cris Chocomel. Todos os direitos reservados.</p>
  </div>
</footer>

<div class="toast-wrap" id="toasts" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
@include('partials.chocomel-alerts')
</body>
</html>