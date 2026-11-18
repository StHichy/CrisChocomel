<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sua sacola | Cris Chocomel</title>
<meta name="description" content="Sacola, entrega e pagamento do seu pedido.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">
<link rel="stylesheet" href="{{ asset('css/carrinho.css') }}">
</head>
<body data-page="carrinho">

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
  <div class="sec pt-4">
    <div class="container">
      <h1 class="mb-4">Sua sacola de doces</h1>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (isset($pedidoPronto))
        {{-- Tela de Pedido Concluído --}}
        <div class="panel text-center mx-auto" style="max-width:640px">
          <div class="done-mark"><span data-i="check"></span></div>
          <h2 class="mb-2">Pedido pronto para envio!</h2>
          <p class="muted mb-1">Número do pedido <strong>#{{ $pedidoPronto['numero'] }}</strong></p>
          <p class="muted">Clique no botão abaixo para enviar os detalhes direto no WhatsApp da Cris.</p>

          <div class="text-start p-3 my-4" style="background:var(--surface-2);border-radius:16px">
            @foreach ($pedidoPronto['resumo'] as $linha)
              <div class="mb-1">{{ $linha }}</div>
            @endforeach
            <hr class="my-2">
            <strong>Total: R$ {{ number_format($pedidoPronto['total'], 2, ',', '.') }}</strong>
          </div>

          <div class="d-grid gap-2">
            <a class="btn btn-honey btn-lg" target="_blank" rel="noopener" href="{{ $pedidoPronto['waUrl'] }}">
              <span data-i="chat"></span> Enviar pedido pelo WhatsApp
            </a>
            <a class="btn btn-line" href="{{ route('produtos') }}">Voltar aos produtos</a>
          </div>
        </div>

      @elseif (empty($carrinho))
        {{-- Sacola Vazia --}}
        <div class="panel">
          <div class="empty py-4">
            <h3>Sua sacola está vazia</h3>
            <p>Que tal começar por um pão de mel?</p>
            <a class="btn btn-honey" href="{{ route('produtos') }}">Ver produtos</a>
          </div>
        </div>

      @else
        {{-- Checkout com Itens na Sacola --}}
        <div class="row g-4" id="checkout">
          <div class="col-lg-8">
            {{-- 1. Lista de Produtos --}}
            <div class="panel mb-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0" style="font-size:1.5rem">Itens selecionados</h2>
                <span class="muted">{{ collect($carrinho)->sum('quantidade') }} item(ns)</span>
              </div>

              <div class="d-flex flex-column gap-3">
                @foreach ($carrinho as $id => $item)
                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                      @if (!empty($item['imagem']))
                        <img src="{{ asset($item['imagem']) }}" alt="{{ $item['nome'] }}" style="width:64px; height:64px; object-fit:cover; border-radius:12px;">
                      @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="width:64px; height:64px; border-radius:12px; font-size:.75rem;">Doce</div>
                      @endif
                      <div>
                        <strong class="d-block">{{ $item['nome'] }}</strong>
                        <span class="small muted">R$ {{ number_format($item['preco'], 2, ',', '.') }} cada</span>
                      </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 ms-auto">
                      <form action="{{ route('carrinho.atualizar', $id) }}" method="POST" class="qty m-0">
                        @csrf
                        <button type="submit" name="acao" value="menos" aria-label="Diminuir"><span data-i="minus"></span></button>
                        <span>{{ $item['quantidade'] }}</span>
                        <button type="submit" name="acao" value="mais" aria-label="Aumentar"><span data-i="plus"></span></button>
                      </form>

                      <strong style="min-width:85px; text-align:right">
                        R$ {{ number_format($item['preco'] *$item['quantidade'], 2, ',', '.') }}
                      </strong>

                      <form action="{{ route('carrinho.remover', $id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm text-danger p-1" title="Remover item" aria-label="Remover">
                          <span data-i="trash"></span>
                        </button>
                      </form>
                    </div>
                  </div>
                @endforeach
              </div>

              <a class="btn btn-line btn-sm mt-3" href="{{ route('produtos') }}">
                <span data-i="plus"></span> Adicionar mais doces
              </a>
            </div>

            {{-- 2. Formulário de Entrega e Pagamento --}}
            <form action="{{ route('carrinho.finalizar') }}" method="POST" id="formPedido" class="panel">
              @csrf
              <h2 class="h4 mb-4" style="font-size:1.5rem"><span data-i="pin"></span> Entrega e pagamento</h2>

              <div class="row g-3">
                <div class="col-sm-7">
                  <label class="form-label" for="cName">Nome completo *</label>
                  <input class="form-control" id="cName" name="nome" value="{{ old('nome', auth()->user()->name ?? '') }}" required>
                </div>
                <div class="col-sm-5">
                  <label class="form-label" for="cWpp">WhatsApp (DDD + número) *</label>
                  <input class="form-control" id="cWpp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="(15) 90000-0000" required>
                </div>

                <div class="col-12">
                  <span class="form-label d-block">Forma de recebimento *</span>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="opt">
                        <input class="form-check-input" type="radio" name="modo" value="entrega" checked onchange="toggleEntrega(true)">
                        <span><strong>Entrega via motoboy</strong><small>Embalagem térmica protegida • R$ 12,00</small></span>
                      </label>
                    </div>
                    <div class="col-md-6">
                      <label class="opt">
                        <input class="form-check-input" type="radio" name="modo" value="retirada" onchange="toggleEntrega(false)">
                        <span><strong>Retirada no ateliê</strong><small>Grátis, sem taxa de frete</small></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="addrBox" class="col-12">
                  <div class="row g-3">
                    <div class="col-sm-7">
                      <label class="form-label" for="cAddr">Endereço e número *</label>
                      <input class="form-control" id="cAddr" name="endereco" value="{{ old('endereco') }}">
                    </div>
                    <div class="col-sm-5">
                      <label class="form-label" for="cCity">Bairro / cidade *</label>
                      <input class="form-control" id="cCity" name="cidade" value="{{ old('cidade') }}">
                    </div>
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <span class="form-label d-block">Forma de pagamento *</span>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="opt">
                        <input class="form-check-input" type="radio" name="pagamento" value="Pix" checked>
                        <span><strong>Pix</strong><small>Aprovação imediata. A chave vai no WhatsApp.</small></span>
                      </label>
                    </div>
                    <div class="col-md-6">
                      <label class="opt">
                        <input class="form-check-input" type="radio" name="pagamento" value="Cartão na entrega">
                        <span><strong>Cartão na entrega</strong><small>Levamos a maquininha (crédito/débito).</small></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <label class="form-label" for="cNote">Observação do pedido ou mensagem de presente</label>
                  <textarea class="form-control" id="cNote" name="observacao" rows="2" placeholder="Ex.: Parabéns, Ana! Com carinho, Pedro">{{ old('observacao') }}</textarea>
                </div>
              </div>
            </form>
          </div>

          {{-- Resumo Lateral --}}
          <aside class="col-lg-4">
            <div class="summary position-lg-sticky" style="top:96px">
              <h2 class="h5 mb-3" style="font-size:1.3rem">Resumo do pedido</h2>

              <div class="d-flex justify-content-between mb-2">
                <span class="muted">Subtotal</span>
                <span>R${{ number_format($subtotal, 2, ',', '.') }}</span>
              </div>

              @if ($desconto > 0)
                <div class="d-flex justify-content-between mb-2 text-success">
                  <span>Desconto ({{ $cupom }})</span>
                  <span>- R${{ number_format($desconto, 2, ',', '.') }}</span>
                </div>
              @endif

              <div class="d-flex justify-content-between mb-2">
                <span class="muted">Entrega</span>
                <span id="freteLabel">R$ 12,00</span>
              </div>

              <hr>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Total</strong>
                <strong class="price" id="totalLabel" data-base="{{ $subtotal -$desconto }}">
                  R$ {{ number_format(($subtotal -$desconto) + 12, 2, ',', '.') }}
                </strong>
              </div>

              {{-- Formulário de Cupom --}}
              <form action="{{ route('carrinho.cupom') }}" method="POST" class="mt-3">
                @csrf
                <label class="form-label small mb-1" for="coupon">Cupom de desconto</label>
                <div class="d-flex gap-2">
                  <input class="form-control" id="coupon" name="cupom" value="{{ $cupom }}" placeholder="Ex.: DOCURA" style="text-transform:uppercase">
                  <button class="btn btn-line btn-sm" type="submit">Aplicar</button>
                </div>
                @if (session('cupom_ok'))
                  <p class="small text-success mt-1 mb-0">{{ session('cupom_ok') }}</p>
                @endif
                @if (session('cupom_erro'))
                  <p class="small text-danger mt-1 mb-0">{{ session('cupom_erro') }}</p>
                @endif
              </form>

              <div class="d-grid gap-2 mt-4">
                <button class="btn btn-honey btn-lg" type="submit" form="formPedido">
                  Finalizar pedido
                </button>
              </div>
              <p class="small muted mt-3 mb-0">Seu pedido vai para a produção e é confirmado por WhatsApp.</p>
            </div>
          </aside>
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
      <div class="col-6 col-md-4"><h3 class="h6 text-uppercase" style="letter-spacing:.14em;font-family:var(--f-body);color:var(--on-hero)">Pedidos</h3><p>Confirmação pelo WhatsApp.</p><a class="btn btn-honey btn-sm wa-link" href="https://wa.me/15988081803" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <hr style="border-color:rgba(255,244,220,.18);margin-block:2rem 1rem"><p class="small mb-0">© 2026 Cris Chocomel. Todos os direitos reservados.</p>
  </div>
</footer>

<div class="toast-wrap" id="toasts" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script>
  function toggleEntrega(isEntrega) {
    const addrBox = document.getElementById('addrBox');
    const freteLabel = document.getElementById('freteLabel');
    const totalLabel = document.getElementById('totalLabel');
    const base = parseFloat(totalLabel.dataset.base);
      }
<scrpit>
@include('partials.chocomel-alerts')
</body>