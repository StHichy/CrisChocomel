<!-- Modal de Escolha de Quantidade (Sacola) -->
<div class="modal fade" id="modalQuantidade" tabindex="-1" aria-labelledby="modalQuantidadeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow-lg modal-chocomel-content">
      <form id="formAdicionarSacola" method="POST" action="">
        @csrf
        <div class="modal-header border-0 pb-0 pt-4 px-4">
          <span class="pill" style="font-size: .75rem;">Adicionar à sacola</span>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body px-4 pt-3 pb-2 text-center">
          <img id="modalProdImg" src="" alt="" class="mb-3 shadow-sm d-none" style="width: 96px; height: 72px; object-fit: cover; border-radius: 14px;">
          <h3 class="h5 fw-bold mb-1 modal-title-text" id="modalQuantidadeLabel">Nome do Doce</h3>
          <p class="small modal-muted-text mb-3" id="modalProdPreco">R$ 0,00 cada</p>

          <label for="inputQtdModal" class="small fw-semibold d-block mb-2 modal-title-text">Quantos você deseja?</label>
          <div class="d-inline-flex align-items-center justify-content-center gap-2 p-1 rounded-pill modal-stepper-box">
            <button type="button" class="btn btn-sm rounded-circle fw-bold modal-step-btn" id="btnMenosQtd" style="width: 34px; height: 34px;">−</button>
            <input type="number" name="quantidade" id="inputQtdModal" value="1" min="1" max="99" class="form-control form-control-sm text-center fw-bold border-0 bg-transparent shadow-none modal-input-num" style="width: 54px; font-size: 1.05rem;">
            <button type="button" class="btn btn-sm rounded-circle fw-bold modal-step-btn" id="btnMaisQtd" style="width: 34px; height: 34px;">+</button>
          </div>

          <div class="mt-3 pt-2 border-top modal-subtotal-wrap">
            <span class="small modal-muted-text">Subtotal: </span>
            <strong id="modalProdSubtotal" style="color: #E59E00; font-size: 1.1rem;">R$ 0,00</strong>
          </div>
        </div>

        <div class="modal-footer border-0 px-4 pb-4 pt-2">
          <button type="submit" class="btn btn-honey w-100 py-2 fw-bold">Confirmar na sacola</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Estilos específicos para o Modal se adaptarem perfeitamente ao Modo Claro e Escuro -->
<style>
  .modal-chocomel-content {
    border-radius: 24px;
    background: var(--surface, #ffffff) !important;
    color: var(--ink, #2C1708) !important;
  }
  html[data-theme="dark"] .modal-chocomel-content {
    background: var(--surface, #241409) !important;
    color: var(--ink, #FFF4DC) !important;
    border: 1px solid rgba(255, 244, 220, 0.15) !important;
  }

  .modal-title-text {
    color: var(--ink, #2C1708) !important;
  }
  html[data-theme="dark"] .modal-title-text {
    color: var(--ink, #FFF4DC) !important;
  }

  .modal-muted-text {
    color: var(--muted, #6b5344) !important;
  }
  html[data-theme="dark"] .modal-muted-text {
    color: rgba(255, 244, 220, 0.7) !important;
  }

  .modal-stepper-box {
    background: rgba(229, 158, 0, 0.14);
    border: 1px solid rgba(229, 158, 0, 0.35);
  }

  .modal-step-btn {
    background: #ffffff;
    color: #2C1708;
    border: none;
  }
  .modal-step-btn:hover {
    background: #E59E00;
    color: #2C1708;
  }
  html[data-theme="dark"] .modal-step-btn {
    background: #2c1708;
    color: #FFF4DC;
    border: 1px solid rgba(255, 244, 220, 0.2);
  }
  html[data-theme="dark"] .modal-step-btn:hover {
    background: #E59E00;
    color: #241409;
  }

  .modal-input-num {
    color: var(--ink, #2C1708) !important;
  }
  html[data-theme="dark"] .modal-input-num {
    color: var(--ink, #FFF4DC) !important;
  }
  /* Remove as setinhas feias do input number no Chrome/Safari/Firefox */
  .modal-input-num::-webkit-outer-spin-button,
  .modal-input-num::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  .modal-input-num {
    -moz-appearance: textfield;
  }

  .modal-subtotal-wrap {
    border-color: rgba(128,128,128,.18) !important;
  }
</style>

<!-- SweetAlert2 + Tema Artesanal Cris Chocomel -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  .swal-chocomel-popup {
    border-radius: 24px !important;
    font-family: 'Figtree', sans-serif !important;
    border: 1px solid rgba(229, 158, 0, 0.35) !important;
    padding: 1.75rem 1.5rem !important;
  }
  .swal-chocomel-title {
    font-family: 'Bricolage Grotesque', sans-serif !important;
    font-weight: 800 !important;
  }
  .swal-chocomel-confirm {
    background: #E59E00 !important;
    color: #2C1708 !important;
    font-weight: 700 !important;
    border-radius: 999px !important;
    padding: 0.6rem 1.5rem !important;
    border: none !important;
    box-shadow: none !important;
  }
  .swal-chocomel-confirm:hover {
    background: #d18f00 !important;
  }
  .swal-chocomel-cancel {
    background: transparent !important;
    border: 1px solid rgba(128, 128, 128, 0.35) !important;
    color: inherit !important;
    font-weight: 600 !important;
    border-radius: 999px !important;
    padding: 0.6rem 1.35rem !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // 1. Configuração global do SweetAlert2 com as cores da Cris Chocomel
    const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';

    window.ChocomelSwal = Swal.mixin({
      background: isDark() ? '#241409' : '#FFFDF9',
      color: isDark() ? '#FFF4DC' : '#2C1708',
      iconColor: '#E59E00',
      customClass: {
        popup: 'swal-chocomel-popup',
        title: 'swal-chocomel-title',
        confirmButton: 'swal-chocomel-confirm',
        cancelButton: 'swal-chocomel-cancel'
      },
      buttonsStyling: false
    });

    // 2. Dispara automaticamente alertas de sessão do Laravel (substituindo os alerts antigos)
    @if (session('success'))
      ChocomelSwal.fire({
        icon: 'success',
        title: 'Tudo certo!',
        text: @json(session('success')),
        timer: 3200,
        showConfirmButton: false,
        timerProgressBar: true
      });
    @endif

    @if (session('error'))
      ChocomelSwal.fire({
        icon: 'error',
        title: 'Ops!',
        text: @json(session('error')),
        confirmButtonText: 'Entendi'
      });
    @endif

    @if ($errors->any())
      ChocomelSwal.fire({
        icon: 'warning',
        title: 'Verifique os dados',
        text: @json($errors->first()),
        confirmButtonText: 'Corrigir'
      });
    @endif

    // 3. Substitui todos os confirm() nativos (ex: Excluir produto/categoria) pelo SweetAlert2
    document.querySelectorAll('form[data-confirm]').forEach(form => {
      form.addEventListener('submit', function (e) {
        if (this.dataset.confirmed === 'true') return;
        e.preventDefault();

        ChocomelSwal.fire({
          icon: 'warning',
          title: 'Tem certeza?',
          text: this.dataset.confirm,
          showCancelButton: true,
          confirmButtonText: 'Sim, excluir',
          cancelButtonText: 'Cancelar',
          reverseButtons: true
        }).then(result => {
          if (result.isConfirmed) {
            this.dataset.confirmed = 'true';
            this.submit();
          }
        });
      });
    });

    // 4. Lógica do Modal de Quantidade ao clicar em "+ Sacola"
    const modalEl = document.getElementById('modalQuantidade');
    if (modalEl) {
      const bsModal = new bootstrap.Modal(modalEl);
      const form = document.getElementById('formAdicionarSacola');
      const titleEl = document.getElementById('modalQuantidadeLabel');
      const precoEl = document.getElementById('modalProdPreco');
      const subtotalEl = document.getElementById('modalProdSubtotal');
      const imgEl = document.getElementById('modalProdImg');
      const inputQtd = document.getElementById('inputQtdModal');
      let precoAtual = 0;

      const formatarBRL = (valor) => valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

      const atualizarSubtotal = () => {
        const qtd = Math.max(1, parseInt(inputQtd.value) || 1);
        inputQtd.value = qtd;
        subtotalEl.textContent = formatarBRL(precoAtual * qtd);
      };

      document.getElementById('btnMenosQtd').addEventListener('click', () => {
        if (parseInt(inputQtd.value) > 1) {
          inputQtd.value = parseInt(inputQtd.value) - 1;
          atualizarSubtotal();
        }
      });

      document.getElementById('btnMaisQtd').addEventListener('click', () => {
        inputQtd.value = (parseInt(inputQtd.value) || 1) + 1;
        atualizarSubtotal();
      });

      inputQtd.addEventListener('input', atualizarSubtotal);

      document.querySelectorAll('.btn-abrir-sacola').forEach(btn => {
        btn.addEventListener('click', () => {
          form.action = btn.dataset.url;
          titleEl.textContent = btn.dataset.nome;
          precoAtual = parseFloat(btn.dataset.preco);
          precoEl.textContent = `${formatarBRL(precoAtual)} cada`;

          if (btn.dataset.imagem) {
            imgEl.src = btn.dataset.imagem;
            imgEl.alt = btn.dataset.nome;
            imgEl.classList.remove('d-none');
          } else {
            imgEl.classList.add('d-none');
          }

          inputQtd.value = 1;
          atualizarSubtotal();
          bsModal.show();
        });
      });
    }
  });
</script>