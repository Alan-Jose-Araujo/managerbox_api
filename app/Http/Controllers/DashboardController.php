<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemInStock;

class DashboardController extends Controller
{
    public function index()
    {
        $items = ItemInStock::latest()->take(5)->get(); // Buscar os últimos 5 itens
    return view('dashboard', compact('items'));
    }
}

