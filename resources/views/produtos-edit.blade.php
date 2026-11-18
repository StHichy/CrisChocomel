<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Produto | Cris Chocomel</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/png" href="{{ asset('favo-de-mel.png') }}">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">

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
              <li><a class="dropdown-item" href="{{ route('produtos.create') }}">+ Novo Produto</a></li>
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
<section>
  <div class="sec">
    <div class="container" style="max-width: 780px;">
      <div class="panel">
        <span class="pill mb-2">Área do Administrador</span>
        <h1 class="h2 mb-1">Editar produto</h1>
        <p class="muted mb-4">Altere as informações de <strong>{{ $produto->nome }}</strong> abaixo.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label fw-semibold">Nome do Produto *</label>
                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    class="form-control @error('nome') is-invalid @enderror" 
                    value="{{ old('nome', $produto->nome) }}" 
                    required
                >
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label fw-semibold">Descrição</label>
                <textarea 
                    id="descricao" 
                    name="descricao" 
                    class="form-control @error('descricao') is-invalid @enderror" 
                    rows="3"
                >{{ old('descricao', $produto->descricao) }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="preco" class="form-label fw-semibold">Preço (R$) *</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        min="0"
                        id="preco" 
                        name="preco" 
                        class="form-control @error('preco') is-invalid @enderror" 
                        value="{{ old('preco', $produto->preco) }}" 
                        required
                    >
                    @error('preco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="categoria" class="form-label fw-semibold">Categoria</label>
                    <select id="categoria" name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
    <option value="">Selecione...</option>
    @foreach ($categorias as $cat)
        <option value="{{ $cat->slug }}" {{ old('categoria', $produto->categoria) == $cat->slug ? 'selected' : '' }}>
            {{ $cat->nome }}
        </option>
    @endforeach
</select>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label fw-semibold">Foto do Produto</label>
                @if ($produto->imagem)
                    <div class="mb-2">
<img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;">                        <span class="small muted ms-2">Foto atual (envie outra apenas se quiser trocar)</span>
                    </div>
                @endif
                <input 
                    type="file" 
                    id="imagem" 
                    name="imagem" 
                    class="form-control @error('imagem') is-invalid @enderror" 
                    accept="image/*"
                >
                @error('imagem')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="destaque" name="destaque" value="1" {{ old('destaque', $produto->destaque) ? 'checked' : '' }}>
                <label class="form-check-label" for="destaque">
                    Exibir este produto nos destaques da página inicial
                </label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-honey">Salvar Alterações</button>
                <a href="{{ route('produtos') }}" class="btn btn-line">Cancelar</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>

<!-- Cole aqui o mesmo <footer class="footer"> das suas outras páginas -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/common.js') }}"></script>
@include('partials.chocomel-alerts')
</body>
</html>