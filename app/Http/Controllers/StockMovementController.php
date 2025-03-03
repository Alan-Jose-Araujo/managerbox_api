<?php

namespace App\Http\Controllers;

use App\Models\ItemInStock;
use App\Models\StockMovement;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class StockMovementController extends Controller
{
    use SendJsonResponses;

    /**
     * Display a listing of the resource.
     */
    public function index($id)
{
    $item = ItemInStock::findOrFail($id);
    $movements = StockMovement::where('item_in_stock_id', $id)
        ->orderBy('created_at', 'desc')
        ->with('item') // Garante que a relação 'item' seja carregada
        ->get();
    
    return view('items.movements', compact('item', 'movements'));
}

    
    public function store(Request $request, $id)
    {
        $request->validate([
            'movement_type' => 'required|in:checkin,checkout',
            'quantity' => 'required|numeric|min:1',
        ]);
    
        $item = ItemInStock::findOrFail($id);
        
        // Verifica se o usuário está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para registrar uma movimentação.');
        }

        $user = auth()->user();
    
        // Atualiza a quantidade do estoque
        if ($request->movement_type == 'checkin') {
            $item->current_quantity += $request->quantity;
        } elseif ($request->movement_type == 'checkout') {
            if ($item->current_quantity < $request->quantity) {
                return back()->with('error', 'Estoque insuficiente para essa saída.');
            }
            $item->current_quantity -= $request->quantity;
        }
    
        $item->save();
    
        // Salva a movimentação
        StockMovement::create([
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'company_id' => $user->company_id,
            'item_in_stock_id' => $id,
        ]);
    
        return back()->with('success', 'Movimentação registrada com sucesso.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        try
        {
//        return View::make('')->with($stockMovement)->render();
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }
}