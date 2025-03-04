<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemInStock\StoreItemInStockRequest;
use App\Http\Requests\ItemInStock\UpdateItemInStockRequest;
use App\Models\ItemInStock;
use App\Models\Category;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ItemInStockController extends Controller
{
    use SendJsonResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        $categories = Category::all();
        $categoryId = $request->input('category_id');
        $search = $request->input('search');
        $lowStock = $request->input('lowStock');
        
        $query = ItemInStock::query();
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('description', 'LIKE', '%' . $search . '%')
                      ->orWhereIn('category_id', function ($query) use ($search) {
                          $query->select('id')->from('categories')->where('name', 'LIKE', '%' . $search . '%');
                      })
                      ->orWhere('current_quantity', 'LIKE', '%' . $search . '%');
            });
        }
        
        if ($lowStock) {
            $query->where('current_quantity', '<', 5);
        }

        $query->where('deleted_at', null);

        $items = $query->get();
        
        return view('items.index', compact('items', 'categories'));
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
        $categories = Category::all();
        return view('items.create', compact('categories'));
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
                'unity_type' => 'required|string|max:10',
                'location' => 'nullable|string',
                'is_active' => 'boolean',
                'image' => 'nullable|image|max:2048',
                'category_id' => 'nullable|integer|exists:categories,id',
                'minimum_quantity' => 'required|integer|min:0'// Adicionado aqui
            ]);

            // Adicionar company_id e categoria
            $validatedData['company_id'] = $companyId;
            $validatedData['sku_code'] = $this->generateSkuCode();
            $validatedData['barcode'] = $validatedData['barcode'] ?? $this->generateBarcode();
            $validatedData['unity_type'] = $validatedData['unity_type'] ?? 'U';
            $validatedData['current_quantity'] = $validatedData['current_quantity'] ?? 0;
            $validatedData['is_active'] = $request->has('is_active');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                
                // Armazena a imagem na pasta public/ItemsInStock/images
                $file->move(public_path('ItemsInStock/images'), $fileName);
            
                // Salva apenas o caminho relativo no banco de dados
                $validatedData['picture'] = 'ItemsInStock/images/' . $fileName;
            } else {
                $validatedData['picture'] = null;
            }
            

            Log::info('Tentando criar item', ['company_id' => $companyId]);
            Log::info('Usuário autenticado:', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()?->email,
                'company_id' => auth()->user()?->company_id
            ]);

            // Criar o item no banco
            ItemInStock::create($validatedData);

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
        $item = ItemInStock::find($id);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = ItemInStock::find($id);
    
        $data = $request->all();
    
        // Se houver um novo arquivo de imagem, salva e atualiza o campo
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            // Armazena a imagem na pasta public/ItemsInStock/images
            $file->move(public_path('ItemsInStock/images'), $fileName);
            
            // Remover a imagem antiga, se existir
            if ($item->picture && file_exists(public_path($item->picture))) {
                unlink(public_path($item->picture));
            }
            
            // Salva apenas o caminho relativo no banco de dados
            $data['picture'] = 'ItemsInStock/images/' . $fileName;
        }
    
        // Inclua a categoria nos dados
        $data['category_id'] = $request->input('category_id');
        $data['minimum_quantity'] = $request->input('minimum_quantity');

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
        if ($item->picture && Storage::disk('public')->has($item->picture)) {
            Storage::disk('public')->delete($item->picture);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item excluído com sucesso!');
    }
}

