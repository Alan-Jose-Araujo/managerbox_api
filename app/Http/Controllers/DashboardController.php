<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        // Contagem de itens com estoque baixo
        $lowStockCount = DB::table('items_in_stock')
            ->where('company_id', $companyId)
            ->where('current_quantity', '<', 5)
            ->count();

        // Contagem total de itens em estoque
        $totalItemsInStock = DB::table('items_in_stock')
            ->where('company_id', $companyId)
            ->count();

        // Contagem total de movimentações de estoque
        $totalStockMovements = StockMovement::count();

        // Contagem de produtos ativos
        $activeProductsCount = DB::table('items_in_stock')
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->count();

        // Últimos itens cadastrados
        $items = DB::table('items_in_stock')
            ->where('company_id', $companyId)
            ->latest()
            ->take(5)
            ->get();

        // Últimas movimentações
        $movements = StockMovement::with('item')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', [
            'lowStockCount' => $lowStockCount,
            'totalItemsInStock' => $totalItemsInStock,
            'totalStockMovements' => $totalStockMovements,
            'activeProductsCount' => $activeProductsCount,
            'items' => $items,
            'movements' => $movements,
        ]);
    }
}

