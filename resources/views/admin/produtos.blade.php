<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciar Produtos (Admin) | Cris Chocomel</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">
<style>
  /* Modo Claro (padrão): texto escuro */
  .admin-table > :not(caption) > * > * {
    background-color: transparent !important;
    color: #2C1708 !important;
    border-bottom-color: rgba(44, 23, 8, 0.14) !important;
  }

  .admin-table thead > tr > th {
    background-color: rgba(229, 158, 0, 0.12) !important;
    color: #2C1708 !important;
    font-weight: 700;
    padding-block: 0.9rem;
  }

  .admin-table tbody > tr > td {
    padding-block: 0.9rem;
  }

  .admin-table .prod-desc {
    color: #6b5344 !important;
  }

  /* Modo Escuro ativado pelo botão da navbar */
  html[data-theme="dark"] .admin-table > :not(caption) > * > * {
    color: #FFF4DC !important;
    border-bottom-color: rgba(255, 244, 220, 0.14) !important;
  }

  html[data-theme="dark"] .admin-table thead > tr > th {
    background-color: rgba(255, 244, 220, 0.08) !important;
    color: #FFF4DC !important;
  }

  html[data-theme="dark"] .admin-table .prod-desc {
    color: rgba(255, 244, 220, 0.72) !important;
  }

  /* Caso o navegador esteja em modo escuro automático sem clique no botão */
  @media (prefers-color-scheme: dark) {
    html:not([data-theme="light"]) .admin-table > :not(caption) > * > * {
      color: #FFF4DC !important;
      border-bottom-color: rgba(255, 244, 220, 0.14) !important;
    }
    html:not([data-theme="light"]) .admin-table thead > tr > th {
      background-color: rgba(255, 244, 220, 0.08) !important;
      color: #FFF4DC !important;
    }
    html:not([data-theme="light"]) .admin-table .prod-desc {
      color: rgba(255, 244, 220, 0.72) !important;
    }
  }

  /* Hover e botões de ação */
  .admin-table tbody > tr:hover > * {
    background-color: rgba(229, 158, 0, 0.1) !important;
  }

  .btn-inativar {
    border: 1px solid #d97706 !important;
    color: #d97706 !important;
    background: transparent !important;
  }
  .btn-inativar:hover {
    background: #d97706 !important;
    color: #fff !important;
  }
  html[data-theme="dark"] .btn-inativar {
    border-color: #fbbf24 !important;
    color: #fbbf24 !important;
  }
  html[data-theme="dark"] .btn-inativar:hover {
    background: #fbbf24 !important;
    color: #2C1708 !important;
  }
</style>
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
  <div class="sec pt-4">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
          <span class="pill mb-2">Painel do Administrador</span>
          <h1 class="h2 mb-1">Gerenciar Produtos</h1>
          <p class="muted mb-0">Controle quais doces aparecem na vitrine da loja.</p>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('produtos') }}" class="btn btn-line">Ver vitrine pública</a>
          <a href="{{ route('produtos.create') }}" class="btn btn-honey">+ Novo Produto</a>
        </div>
      </div>

      <!-- Gerenciar Categorias -->
      <div class="panel mb-4">
        <div class="row g-3 align-items-center">
          <div class="col-lg-5">
            <h2 class="h5 mb-1">Categorias da loja</h2>
            <p class="small muted mb-2">Crie novas categorias para organizar o cardápio.</p>
            
            <form action="{{ route('categorias.store') }}" method="POST" class="d-flex gap-2">
              @csrf
              <input 
                type="text" 
                name="nome" 
                class="form-control @error('nome') is-invalid @enderror" 
                placeholder="Ex: Trufas, Bolos de pote..." 
                required
              >
              <button type="submit" class="btn btn-honey text-nowrap">+ Adicionar</button>
            </form>
            @error('nome')
              <div class="small text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-lg-7">
            <span class="small muted d-block mb-2">Categorias cadastradas:</span>
            <div class="d-flex flex-wrap gap-2">
              @forelse ($categorias as $cat)
                <span class="badge d-inline-flex align-items-center gap-2 px-3 py-2" style="background: rgba(229, 158, 0, 0.16); color: inherit; font-size: .85rem; border: 1px solid rgba(229, 158, 0, 0.35); border-radius: 999px;">
                  {{ $cat->nome }}
                  <form action="{{ route('categorias.destroy', $cat->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Excluir a categoria {{ $cat->nome }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-close" style="font-size: .6rem;" aria-label="Remover {{ $cat->nome }}"></button>
                  </form>
                </span>
              @empty
                <span class="small muted">Nenhuma categoria cadastrada ainda.</span>
              @endforelse
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros do Admin (Todos / Ativos / Inativos + Busca) -->
      <div class="panel mb-4">
        <form method="GET" action="{{ route('admin.produtos') }}" class="row g-3 align-items-center">
          <div class="col-md-7 d-flex flex-wrap gap-2">
            <a href="{{ route('admin.produtos', request()->except('status')) }}" 
               class="btn btn-sm {{ !request('status') ? 'btn-honey' : 'btn-line' }}">
               Todos ({{ \App\Models\Produto::count() }})
            </a>
            <a href="{{ route('admin.produtos', array_merge(request()->query(), ['status' => 'ativos'])) }}" 
               class="btn btn-sm {{ request('status') === 'ativos' ? 'btn-honey' : 'btn-line' }}">
               Ativos ({{ \App\Models\Produto::where('ativo', true)->count() }})
            </a>
            <a href="{{ route('admin.produtos', array_merge(request()->query(), ['status' => 'inativos'])) }}" 
               class="btn btn-sm {{ request('status') === 'inativos' ? 'btn-honey' : 'btn-line' }}">
               Inativos ({{ \App\Models\Produto::where('ativo', false)->count() }})
            </a>
          </div>

          @if (request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif

          <div class="col-md-5 d-flex gap-2">
            <input type="search" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar produto por nome...">
            <button type="submit" class="btn btn-line">Buscar</button>
          </div>
        </form>
      </div>

      <!-- Tabela de Produtos -->
      <div class="panel p-0 overflow-hidden">
        @if ($produtos->isEmpty())
          <div class="p-5 text-center">
            <h3>Nenhum produto encontrado</h3>
            <p class="muted">Cadastre um novo doce ou limpe os filtros acima.</p>
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover admin-table align-middle mb-0">
              <thead>
                <tr>
                  <th class="ps-4">Produto</th>
                  <th>Categoria</th>
                  <th>Preço</th>
                  <th>Destaque</th>
                  <th>Status</th>
                  <th class="text-end pe-4">Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produtos as $produto)
                  <tr style="{{ !$produto->ativo ? 'opacity: 0.7;' : '' }}">
                    <td class="ps-4">
                      <div class="d-flex align-items-center gap-3">
                       @if ($produto->imagem)
  <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width: 52px; height: 52px; object-fit: cover; border-radius: 10px;">
@else
  <div class="d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; border-radius: 10px; font-size: .75rem; background: rgba(229, 158, 0, 0.15);">
    Sem foto
  </div>
@endif
                        <div>
                          <strong class="d-block">{{ $produto->nome }}</strong>
                          <span class="small prod-desc text-truncate d-inline-block" style="max-width: 240px;">{{ $produto->descricao }}</span>
                        </div>
                      </div>
                    </td>

                    <td>{{ ucfirst($produto->categoria ?? '-') }}</td>

                    <td><strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong></td>

                    <td>
                      @if ($produto->destaque)
                        <span class="badge bg-warning text-dark">Sim</span>
                      @else
                        <span class="prod-desc small">Não</span>
                      @endif
                    </td>

                    <td>
                      @if ($produto->ativo)
                        <span class="badge bg-success">Ativo</span>
                      @else
                        <span class="badge bg-secondary">Inativo</span>
                      @endif
                    </td>

                    <td class="text-end pe-4">
                      <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                        <!-- Botão Ativar / Inativar -->
                        <form action="{{ route('produtos.toggle', $produto->id) }}" method="POST" class="m-0">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm {{ $produto->ativo ? 'btn-inativar' : 'btn-outline-success' }}">
                            {{ $produto->ativo ? 'Inativar' : 'Ativar' }}
                          </button>
                        </form>

                        <!-- Botão Editar -->
                        <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-line btn-sm">
                          Editar
                        </a>

                        <!-- Botão Excluir -->
                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente {{ $produto->nome }}?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger btn-sm">
                            Excluir
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
@include('partials.chocomel-alerts')
</body>
</html>