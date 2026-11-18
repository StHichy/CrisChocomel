<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cris Chocomel</title>
<meta name="description" content="Doceria artesanal: pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.">
<link rel="icon" type="image/png" href="{{ asset('favo-de-mel.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<style>
  .cat-carousel-wrap {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .cat-carousel-track {
    display: flex !important;
    flex-wrap: nowrap !important;
    gap: 1.25rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding-block: 0.5rem;
    width: 100%;
    justify-content: flex-start;
  }

  /* Centraliza automaticamente quando houver até 4 categorias no desktop */
  @media (min-width: 992px) {
    .cat-carousel-track:not(:has(.cat-carousel-item:nth-child(5))) {
      justify-content: center;
    }
    .cat-carousel-wrap:not(:has(.cat-carousel-item:nth-child(5))) .cat-nav-btn {
      display: none;
    }
  }

  .cat-carousel-track::-webkit-scrollbar {
    display: none;
  }

  .cat-carousel-item {
    flex: 0 0 calc(25% - 0.95rem);
    min-width: 230px;
    scroll-snap-align: start;
  }

  .cat-carousel-item .cat-card {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-decoration: none !important;
    background: var(--surface, #ffffff);
    color: var(--ink, #2C1708) !important;
    border: 1px solid rgba(44, 23, 8, 0.12);
    border-radius: 22px;
    padding: 1.5rem 1.35rem;
    box-shadow: 0 6px 18px -8px rgba(44, 23, 8, 0.12);
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
  }

  html[data-theme="dark"] .cat-carousel-item .cat-card {
    background: var(--surface, #241409);
    color: var(--ink, #FFF4DC) !important;
    border-color: rgba(255, 244, 220, 0.14);
    box-shadow: 0 6px 18px -8px rgba(0, 0, 0, 0.45);
  }

  .cat-carousel-item .cat-card:hover {
    transform: translateY(-4px);
    border-color: #E59E00;
    box-shadow: 0 12px 24px -10px rgba(44, 23, 8, 0.2);
  }

  .cat-carousel-item .cat-card h3 {
    color: inherit !important;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.35rem;
  }

  .cat-carousel-item .cat-card p {
    color: var(--muted, #6b5344) !important;
    font-size: 0.92rem;
    margin-bottom: 1.15rem;
  }

  html[data-theme="dark"] .cat-carousel-item .cat-card p {
    color: rgba(255, 244, 220, 0.72) !important;
  }

  .cat-carousel-item .cat-card .go {
    color: #c88600;
    font-weight: 600;
    font-size: 0.92rem;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }

  html[data-theme="dark"] .cat-carousel-item .cat-card .go {
    color: #fbbf24;
  }

  /* Ícones maiores, encorpados e nítidos */
  .cat-carousel-item .cat-ic {
    width: 68px;
    height: 68px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(229, 158, 0, 0.24), rgba(229, 158, 0, 0.08));
    border: 1px solid rgba(229, 158, 0, 0.3);
    color: #c97e00;
    margin-bottom: 1.25rem;
    transition: transform 0.2s ease, background 0.2s ease;
  }

  .cat-carousel-item .cat-card:hover .cat-ic {
    transform: scale(1.06);
    background: rgba(229, 158, 0, 0.28);
  }

  html[data-theme="dark"] .cat-carousel-item .cat-ic {
    color: #fbbf24;
    border-color: rgba(251, 191, 36, 0.28);
  }

  .cat-carousel-item .cat-ic svg {
    width: 36px;
    height: 36px;
    display: block;
    shape-rendering: geometricPrecision;
  }

  .cat-nav-btn {
    flex: 0 0 auto;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid rgba(128, 128, 128, 0.25);
    background: var(--surface, #fff);
    color: inherit;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    cursor: pointer;
    transition: background-color 0.2s;
  }

  .cat-nav-btn:hover {
    background: #E59E00;
    color: #2C1708;
    border-color: #E59E00;
  }

  @media (max-width: 576px) {
    .cat-carousel-item { flex: 0 0 74%; min-width: 205px; }
    .cat-nav-btn { display: none; }
  }
</style>
</head>
<body data-page="index">

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
  <div class="hero">
    <div class="container position-relative" style="z-index:2">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="pill word" style="animation-delay:.05s"><span id="pillIcon"></span> Doces feitos com amor</span>
          <h1 class="mt-3 mb-4" id="heroTitle">Doces artesanais que adoçam os seus <em>melhores momentos</em></h1>
          <p class="lead-s mb-4 word" style="animation-delay:.7s">Produtos feitos com ingredientes de alta qualidade e com muito amor pela as mãos da CrisChocomel</p>
          <div class="d-flex flex-wrap gap-3 mb-5 word" style="animation-delay:.85s">
            <a class="btn btn-honey btn-lg" href="{{ route('produtos') }}">Explorar produtos <span data-i="arrow"></span></a>
            <a class="btn btn-hero-line btn-lg" href="{{ route('sobre') }}">Conhecer a Cris</a>
          </div>
          <div class="trust word" style="animation-delay:1s">
            <div><strong>Mel puro</strong>Sem conservantes</div>
            <div><strong>Chocolate nobre</strong>Cacau selecionado</div>
            <div><strong>Fresquinho</strong>Lotes pequenos</div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="scene" id="scene" aria-hidden="true">
            <div class="hexa"></div><div class="hexb"></div>
            <div class="main" data-depth="14" id="sceneMain"></div>
            <div class="s1" data-depth="-22" id="sceneS1"></div>
            <div class="s2" data-depth="22" id="sceneS2"></div>
            <svg class="stamp" viewBox="0 0 100 100"><circle class="disc" cx="50" cy="50" r="49"/><defs><path id="circ" d="M50 50m-36 0a36 36 0 1 1 72 0a36 36 0 1 1-72 0"/></defs><text><textPath href="#circ" textLength="222" lengthAdjust="spacing">Cris Chocomel · feito à mão · </textPath></text><path d="M50 36l11 6.5v13L50 62l-11-6.5v-13z" fill="#E59E00"/></svg>
          </div>
        </div>
      </div>
      <svg class="bee" style="top:5%;left:64%" viewBox="0 0 46 40" aria-hidden="true"><ellipse class="wing" cx="17" cy="9" rx="8" ry="10" fill="#FFF4DC" opacity=".85" transform="rotate(-20 17 9)"/><ellipse class="wing" cx="29" cy="9" rx="8" ry="10" fill="#FFF4DC" opacity=".85" transform="rotate(20 29 9)"/><ellipse cx="23" cy="26" rx="15" ry="11" fill="#E59E00"/><path d="M17 16v20M24 15v22M31 16v20" stroke="#2C1708" stroke-width="4"/><circle cx="35" cy="22" r="1.8" fill="#2C1708"/></svg>
      <svg class="bee b2" style="top:80%;left:50%" viewBox="0 0 46 40" aria-hidden="true"><ellipse class="wing" cx="17" cy="9" rx="8" ry="10" fill="#FFF4DC" opacity=".85" transform="rotate(-20 17 9)"/><ellipse class="wing" cx="29" cy="9" rx="8" ry="10" fill="#FFF4DC" opacity=".85" transform="rotate(20 29 9)"/><ellipse cx="23" cy="26" rx="15" ry="11" fill="#E59E00"/><path d="M17 16v20M24 15v22M31 16v20" stroke="#2C1708" stroke-width="4"/><circle cx="35" cy="22" r="1.8" fill="#2C1708"/></svg>
    </div>
  </div>
  <div class="drip-wrap" aria-hidden="true"><svg class="drip-svg" viewBox="0 0 1200 110" preserveAspectRatio="xMidYMin meet"></svg></div>

  <div class="marquee-wrap" aria-hidden="true"><div class="sec pt-3"><div class="marquee-track" id="marquee"></div></div></div>

  <!-- Destaques da semana vindos do Banco de Dados -->
  <div class="sec pt-3">
    <div class="container">
      <div class="sec-head rv">
        <div><span class="eyebrow">Destaques da semana</span><h2>Os queridinhos do ateliê</h2></div>
        <a class="btn btn-line btn-sm" href="{{ route('produtos') }}">Ver cardápio completo <span data-i="arrow"></span></a>
      </div>

      @if ($produtosDestaque->isEmpty())
        <p class="muted">Nenhum produto em destaque no momento. <a href="{{ route('produtos') }}">Veja todo o nosso cardápio</a>.</p>
      @else
        <div class="row g-4" id="featured">
          @foreach ($produtosDestaque as $index => $produto)
            <div class="col-6 col-lg-3">
              <article class="pcard" style="--i:{{ $index }}">
                <div class="art">
  @if ($produto->imagem)
    <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">
  @else
    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
      Sem foto
    </div>
  @endif
  <span class="tag">Destaque</span>
</div>

                <div class="pbody">
                  <h3 class="pname h5 mb-1">{{ $produto->nome }}</h3>
                  <p class="pdesc">{{ $produto->descricao }}</p>

                  <div class="pfoot">
                    <span class="price">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    
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

  <!-- Carrossel de Categorias do Banco de Dados -->
  <div class="sec sec-alt">
    <div class="container">
      <div class="sec-head rv">
        <div>
          <span class="eyebrow">Escolha por categoria</span>
          <h2>O que você quer adoçar hoje?</h2>
        </div>
        <a class="btn btn-line btn-sm" href="{{ route('produtos') }}">Ver todas <span data-i="arrow"></span></a>
      </div>

      @if ($categorias->isEmpty())
        <p class="muted">Nenhuma categoria cadastrada ainda.</p>
      @else
        <div class="cat-carousel-wrap">
          <button type="button" class="cat-nav-btn" id="homeCatPrev" aria-label="Categorias anteriores">‹</button>

          <div class="cat-carousel-track" id="homeCatTrack">
            @foreach ($categorias as $index => $cat)
              @php
                $qtdProdutos = \App\Models\Produto::where('ativo', true)->where('categoria', $cat->slug)->count();
              @endphp

              <div class="cat-carousel-item">
                <a class="cat-card" href="{{ route('produtos', ['categoria' => $cat->slug]) }}" style="--d:{{ $index * 80 }}ms">
                  <div>
                    <div class="cat-ic" aria-hidden="true">
                      @switch($cat->slug)
                        @case('pao')
                          {{-- Pão de Mel com calda de chocolate --}}
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 14.5C4 9.8 7.6 6 12 6s8 3.8 8 8.5v2A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-2Z" fill="currentColor" fill-opacity="0.22"/>
                            <path d="M4.5 13c1.5 1.4 3 1.4 4.5 0s3-1.4 4.5 0 3 1.4 4.5 0c.7-.6 1.1-.8 1.5-.8"/>
                            <path d="M9 10.2h.01M15 10.2h.01M12 9h.01" stroke-width="2.2"/>
                          </svg>
                          @break

                        @case('brigadeiro')
                          {{-- Brigadeiro Gourmet na forminha plissada --}}
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="10" r="5.5" fill="currentColor" fill-opacity="0.24"/>
                            <path d="M6 14.5l1.6 5.5h8.8L18 14.5" fill="currentColor" fill-opacity="0.12"/>
                            <path d="M10 14.5l.6 5.5M14 14.5l-.6 5.5"/>
                            <path d="M10 8.5l1.2 1.2M13.8 8l-.8 1.5M11.5 11.8h1.5" stroke-width="1.9"/>
                          </svg>
                          @break

                        @case('cone')
                          {{-- Cone Trufado crocante --}}
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7.5 10.5L12 21l4.5-10.5" fill="currentColor" fill-opacity="0.22"/>
                            <path d="M6.5 10.5C6.5 7.4 9 5 12 5s5.5 2.4 5.5 5.5c0 .8-.7 1.5-1.5 1.5H8c-.8 0-1.5-.7-1.5-1.5Z" fill="currentColor" fill-opacity="0.12"/>
                            <path d="M9.2 14.5h5.6M10.6 17.8h2.8"/>
                          </svg>
                          @break

                        @case('caixa')
                          {{-- Caixa de Presente com laço --}}
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="10" width="16" height="10" rx="2" fill="currentColor" fill-opacity="0.22"/>
                            <rect x="3" y="7" width="18" height="3" rx="1" fill="currentColor" fill-opacity="0.14"/>
                            <path d="M12 7v13"/>
                            <path d="M12 7c-1.8-2.8-5-2.8-5 0s3.2 0 5 0Zm0 0c1.8-2.8 5-2.8 5 0s-3.2 0-5 0Z"/>
                          </svg>
                          @break

                        @default
                          {{-- Favo de Mel (padrão para novas categorias) --}}
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3l7.5 4.3v8.6L12 20.2l-7.5-4.3V7.3L12 3Z" fill="currentColor" fill-opacity="0.22"/>
                            <path d="M12 7.5l3.8 2.2v4.4L12 16.3l-3.8-2.2V9.7L12 7.5Z" fill="currentColor" fill-opacity="0.25"/>
                          </svg>
                      @endswitch
                    </div>

                    <h3>{{ $cat->nome }}</h3>
                    <p>{{ $qtdProdutos }} {{ $qtdProdutos === 1 ? 'opção disponível' : 'opções disponíveis' }}</p>
                  </div>

                  <span class="go">Explorar <span data-i="arrow"></span></span>
                </a>
              </div>
            @endforeach
          </div>

          <button type="button" class="cat-nav-btn" id="homeCatNext" aria-label="Próximas categorias">›</button>
        </div>
      @endif
    </div>
  </div>

  <div class="sec">
    <div class="container">
      <div class="row g-4 g-lg-5 align-items-center">
        <div class="col-lg-5 rv"><div class="blob p-4"><div id="aboutArt"></div></div></div>
        <div class="col-lg-7 rv">
          <span class="eyebrow">Confeitaria afetiva</span>
          <h2 class="mt-2 mb-3">Mel de verdade, lotes pequenos, zero pressa</h2>
          <p class="lead-s">Enquanto a indústria busca baratear custos com conservantes e gorduras hidrogenadas, a Cris Chocomel escolheu mel de abelha puro, doce de leite cozido com paciência e chocolate nobre que derrete aveludado.</p>
          <a class="btn btn-solid mt-2" href="{{ route('sobre') }}">Ler a nossa história <span data-i="arrow"></span></a>
        </div>
      </div>
    </div>
  </div>

  <div class="sec sec-alt">
    <div class="container">
      <div class="sec-head rv"><div><span class="eyebrow">Como pedir</span><h2>Do carrinho ao WhatsApp em três passos</h2></div></div>
      <div class="row g-4">
        <div class="col-md-4 rv"><div class="step-n">1</div><h3 class="mt-2">Escolha os doces</h3><p class="muted">Navegue pelo cardápio e adicione à sacola. Monte do jeito que quiser, de um pão de mel a cento de brigadeiros.</p></div>
        <div class="col-md-4 rv" style="--d:120ms"><div class="step-n">2</div><h3 class="mt-2">Informe a entrega</h3><p class="muted">Receba por motoboy com embalagem térmica ou retire no ateliê sem taxa. Deixe uma mensagem de presente se quiser.</p></div>
        <div class="col-md-4 rv" style="--d:240ms"><div class="step-n">3</div><h3 class="mt-2">Confirme pelo WhatsApp</h3><p class="muted">Seu pedido vai para a produção e a confirmação chega direto no seu WhatsApp.</p></div>
      </div>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5"><a class="brand mb-3" href="{{ route('index') }}"><span class="brand-name">Cris <span>chocomel</span></span></a><p class="mb-0">Feito à mão com muito carinho. Pães de mel, brigadeiros gourmet, cones trufados e caixas de presente.</p></div>
      <div class="col-6 col-md-3"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Navegue</h3><div class="d-grid gap-1"><a href="{{ route('index') }}">Início</a><a href="{{ route('produtos') }}">Produtos</a><a href="{{ route('sobre') }}">Sobre a loja</a><a href="{{ route('carrinho') }}">Sacola</a>@guest<a href="{{ route('login') }}">Entrar</a><a href="{{ route('register') }}">Criar conta</a>@endguest</div></div>
      <div class="col-6 col-md-4"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Pedidos</h3><p>Confirmação pelo WhatsApp.</p><a class="btn btn-honey btn-sm wa-link" href="https://wa.me/5515988081803" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <hr style="border-color:rgba(255,244,220,.18);margin-block:2rem 1rem"><p class="small mb-0">© 2026 Cris Chocomel. Todos os direitos reservados.</p>
  </div>
</footer>

<div class="toast-wrap" id="toasts" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('homeCatTrack');
    const prev = document.getElementById('homeCatPrev');
    const next = document.getElementById('homeCatNext');

    if (!track || !prev || !next) return;

    const items = Array.from(track.querySelectorAll('.cat-carousel-item'));

    if (items.length <= 4) return;

    track.style.scrollSnapType = 'none';
    track.style.scrollBehavior = 'auto';

    items.forEach(item => {
      const clone = item.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      track.appendChild(clone);
    });

    let isPaused = false;
    const speed = 0.65;

    function smoothLoop() {
      if (!isPaused) {
        track.scrollLeft += speed;
        const halfWidth = track.scrollWidth / 2;
        if (track.scrollLeft >= halfWidth) {
          track.scrollLeft -= halfWidth;
        }
      }
      requestAnimationFrame(smoothLoop);
    }

    const wrapper = track.parentElement;
    wrapper.addEventListener('mouseenter', () => { isPaused = true; });
    wrapper.addEventListener('mouseleave', () => { isPaused = false; });
    track.addEventListener('touchstart', () => { isPaused = true; }, { passive: true });
    track.addEventListener('touchend', () => {
      setTimeout(() => { isPaused = false; }, 1200);
    });

    const getStep = () => (items[0] ? items[0].offsetWidth + 20 : 260);

    next.addEventListener('click', () => {
      const halfWidth = track.scrollWidth / 2;
      if (track.scrollLeft + getStep() >= halfWidth) {
        track.scrollLeft -= halfWidth;
      }
      track.scrollBy({ left: getStep(), behavior: 'smooth' });
    });

    prev.addEventListener('click', () => {
      const halfWidth = track.scrollWidth / 2;
      if (track.scrollLeft - getStep() <= 0) {
        track.scrollLeft += halfWidth;
      }
      track.scrollBy({ left: -getStep(), behavior: 'smooth' });
    });

    requestAnimationFrame(smoothLoop);
  });
</script>
@include('partials.chocomel-alerts')
</body>
</html>