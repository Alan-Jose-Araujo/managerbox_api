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
    public function index(ItemInStock $itemInStock)
    {
        try
        {
            $stockMovements = StockMovement::where('item_in_stock_id', $itemInStock->id)->orderBy('created_at', 'desc')
            ->get();
//            return View::make('')->with('stockMovements', $stockMovements)->render();
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ItemInStock $itemInStock)
    {
        try
        {
           $validatedData = $request->validate([
               'movement_type' => ['required', 'string', 'in:checkin,checkout'],
               'quantity' => ['required', 'decimal:2', 'min:1', 'digits_between:1,10'],
               'value' => ['nullable', 'decimal:2', 'min:1', 'digits_between:1,10'],
           ]);

           $validatedData['company_id'] = Session::get('company_id');
           $validatedData['item_in_stock_id'] = $itemInStock->id;

           StockMovement::create($validatedData);

//           return;
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
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
