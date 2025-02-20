<?php

namespace App\Http\Controllers;

use App\Models\ItemInStock;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ItemInStockController extends Controller
{
    use SendJsonResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $itemsInStock = ItemInStock::all();

//            return View::make('')->with('itemsInStock', $itemsInStock)->render();
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {

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
    public function show(ItemInStock $itemInStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemInStock $itemInStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemInStock $itemInStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemInStock $itemInStock)
    {
        //
    }
}
