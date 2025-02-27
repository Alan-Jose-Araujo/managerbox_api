<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemInStock\StoreItemInStockRequest;
use App\Http\Requests\ItemInStock\UpdateItemInStockRequest;
use App\Models\ItemInStock;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class ItemInStockController extends Controller
{
    use SendJsonResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = ItemInStock::all(); // Buscar todos os itens no banco
            return view('items.index', compact('items')); // Passar os itens para a view
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Verificar se o usuário está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        // Atualizar os dados do usuário autenticado para evitar problemas de cache
        auth()->user()->refresh();

        // Obter o company_id do usuário autenticado
        $companyId = auth()->user()->company_id;

        if (!$companyId) {
            Log::error('Erro ao cadastrar item: Usuário autenticado sem company_id.', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email,
            ]);
            return response()->json(['error' => 'Empresa não encontrada para este usuário.'], 400);
        }

        // Validar os dados da requisição
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:50|unique:items_in_stock,barcode',
            'description' => 'nullable|string|max:1000',
            'current_quantity' => 'nullable|numeric|min:0',
            'maximum_quantity' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'unity_type' => 'required|string|max:1',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        // Adicionar company_id
        $validatedData['company_id'] = $companyId;
        $validatedData['sku_code'] = $this->generateSkuCode();
        $validatedData['barcode'] = $validatedData['barcode'] ?? $this->generateBarcode();
        $validatedData['unity_type'] = $validatedData['unity_type'] ?? 'U';
        $validatedData['current_quantity'] = $validatedData['current_quantity'] ?? 0;
        $validatedData['is_active'] = $request->has('is_active');

        // Upload de imagem
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('ItemsInStock/images', 'public');
        }

        Log::info('Tentando criar item', ['company_id' => $companyId]);
        Log::info('Usuário autenticado:', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'company_id' => auth()->user()?->company_id
        ]);

        // Criar o item no banco
        $item = ItemInStock::create($validatedData);

        return redirect()->route('items.index')->with('success', 'Produto cadastrado com sucesso!');

    } catch (\Exception $exception) {
        Log::error('Erro ao cadastrar item: ' . $exception->getMessage(), [
            'exception' => $exception,
        ]);
        return response()->json(['error' => 'Ocorreu um erro ao cadastrar o item.'], 500);
    }
}



    private function generateSkuCode(): string
    {
        do {
            $sku = 'SKU-' . strtoupper(substr(uniqid(), -6)); // Exemplo: SKU-ABC123
        } while (ItemInStock::where('sku_code', $sku)->exists());

        return $sku;
    }

    private function generateBarcode(): string
    {
        do {
            $barcode = strtoupper(Str::random(12)); // Gera um código aleatório de 12 caracteres
        } while (ItemInStock::where('barcode', $barcode)->exists()); // Garante que é único

        return $barcode;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    // Buscar o item no banco de dados
    $item = ItemInStock::findOrFail($id);

    // Retornar a view passando o item
    return view('items.show', compact('item'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $item = ItemInStock::findOrFail($id);
    return view('items.edit', compact('item'));
}

public function update(Request $request, $id)
{
    $item = ItemInStock::findOrFail($id);

    $data = $request->all();

    // Se houver um novo arquivo de imagem, salva e atualiza o campo
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $data['picture'] = $path;
    }

    $item->update($data);

    return redirect()->route('items.index')->with('success', 'Item atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $item = ItemInStock::findOrFail($id);
    
    // Remover a imagem do storage, se existir
    if ($item->picture) {
        Storage::disk('public')->delete($item->picture);
    }

    $item->delete();

    return redirect()->route('items.index')->with('success', 'Item excluído com sucesso!');
}
}
