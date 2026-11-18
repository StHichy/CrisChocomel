<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        $cupom = session()->get('cupom', null);

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        // Cupons válidos (ex: BEMVINDA10 ou DOCURA dão 10% de desconto)
        $desconto = 0;
        if ($cupom && in_array(strtoupper($cupom), ['BEMVINDA10', 'DOCURA'])) {
            $desconto = $subtotal * 0.10;
        }

        return view('carrinho', compact('carrinho', 'subtotal', 'desconto', 'cupom'));
    }

    public function adicionar(Request $request, $id)
{
    $produto = Produto::where('ativo', true)->findOrFail($id);
    $quantidade = max(1, (int) $request->input('quantidade', 1));

    $carrinho = session()->get('carrinho', []);

    if (isset($carrinho[$id])) {
        $carrinho[$id]['quantidade'] += $quantidade;
    } else {
        $carrinho[$id] = [
            'id'         => $produto->id,
            'nome'       => $produto->nome,
            'preco'      => $produto->preco,
            'imagem'     => $produto->imagem,
            'quantidade' => $quantidade,
        ];
    }

    session()->put('carrinho', $carrinho);

    $textoQtd = $quantidade === 1 ? '1 unidade' : "{$quantidade} unidades";
    return back()->with('success', "{$textoQtd} de \"{$produto->nome}\" adicionada(s) à sacola!");
}

    public function atualizar(Request $request, $id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $acao = $request->input('acao');

            if ($acao === 'mais') {
                $carrinho[$id]['quantidade']++;
            } elseif ($acao === 'menos') {
                $carrinho[$id]['quantidade']--;
                if ($carrinho[$id]['quantidade'] <= 0) {
                    unset($carrinho[$id]);
                }
            }
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho');
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho');
    }

    public function cupom(Request $request)
    {
        $codigo = strtoupper(trim($request->input('cupom')));

        if (in_array($codigo, ['BEMVINDA10', 'DOCURA'])) {
            session()->put('cupom', $codigo);
            return redirect()->route('carrinho')->with('cupom_ok', "Cupom {$codigo} aplicado (10% OFF)!");
        }

        session()->forget('cupom');
        return redirect()->route('carrinho')->with('cupom_erro', 'Cupom inválido ou expirado.');
    }

    public function finalizar(Request $request)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'whatsapp'   => 'required|string|max:30',
            'modo'       => 'required|in:entrega,retirada',
            'endereco'   => 'required_if:modo,entrega|nullable|string|max:255',
            'cidade'     => 'required_if:modo,entrega|nullable|string|max:100',
            'pagamento'  => 'required|string',
            'observacao' => 'nullable|string|max:500',
        ]);

        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('carrinho');
        }

        $subtotal = 0;
        $linhasItens = [];
        foreach ($carrinho as $item) {
            $totalItem = $item['preco'] * $item['quantidade'];
            $subtotal += $totalItem;
            $linhasItens[] = "• {$item['quantidade']}x {$item['nome']} (R$ " . number_format($totalItem, 2, ',', '.') . ")";
        }

        $cupom = session()->get('cupom');
        $desconto = ($cupom && in_array($cupom, ['BEMVINDA10', 'DOCURA'])) ? $subtotal * 0.10 : 0;
        $frete = ($dados['modo'] === 'entrega') ? 12.00 : 0.00;
        $totalFinal = $subtotal - $desconto + $frete;

        // Monta a mensagem formatada para o WhatsApp
        $numeroPedido = rand(1000, 9999);
        $texto  = "*Novo Pedido #{$numeroPedido} - Cris Chocomel*\n\n";
        $texto .= "*Cliente:* {$dados['nome']}\n";
        $texto .= "*WhatsApp:* {$dados['whatsapp']}\n\n";
        $texto .= "*Itens:*\n" . implode("\n", $linhasItens) . "\n\n";
        $texto .= "*Subtotal:* R$ " . number_format($subtotal, 2, ',', '.') . "\n";
        if ($desconto > 0) {
            $texto .= "*Desconto ({$cupom}):* -R$ " . number_format($desconto, 2, ',', '.') . "\n";
        }
        $texto .= "*Recebimento:* " . ($dados['modo'] === 'entrega' ? "Entrega (R$ 12,00)" : "Retirada no ateliê (Grátis)") . "\n";
        if ($dados['modo'] === 'entrega') {
            $texto .= "*Endereço:* {$dados['endereco']} - {$dados['cidade']}\n";
        }
        $texto .= "*Pagamento:* {$dados['pagamento']}\n";
        if (!empty($dados['observacao'])) {
            $texto .= "*Obs.:* {$dados['observacao']}\n";
        }
        $texto .= "\n*Total a pagar: R$ " . number_format($totalFinal, 2, ',', '.') . "*";

        // Coloque aqui o número do WhatsApp da loja com 55 + DDD (ex: 5515999999999)
        $telefoneLoja = "";
        $waUrl = "https://wa.me/{$telefoneLoja}?text=" . urlencode($texto);

        // Limpa o carrinho da sessão após gerar o pedido
        session()->forget(['carrinho', 'cupom']);

        return view('carrinho', [
            'carrinho'     => [],
            'subtotal'     => 0,
            'desconto'     => 0,
            'cupom'        => null,
            'pedidoPronto' => [
                'numero' => $numeroPedido,
                'waUrl'  => $waUrl,
                'resumo' => $linhasItens,
                'total'  => $totalFinal,
            ],
        ]);
    }
}