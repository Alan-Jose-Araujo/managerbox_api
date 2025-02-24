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
        //TODO: Retornar view de create.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemInStockRequest $request)
    {
        try
        {
            $request['company_id'] = Session::get('company_id');
            $request['unity_type'] = $request['unity_type'] ?? 'unity';
            $request['current_quantity'] = $request['current_quantity'] ?? 0;
            $data = $request->all();
            $imagePath = $request->file('image')?->store('ItemsInStock/images', 'public') ?? null;
            $data['image'] = $imagePath;
            $itemInStock = ItemInStock::create($data);
            //TODO: Redirecionar para outra rota.
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
        //TODO: Retornar view de show.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemInStock $itemInStock)
    {
        //TODO: Retornar view de edit.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemInStockRequest $request, ItemInStock $itemInStock)
    {
        try
        {
            $request['unity_type'] = $request['unity_type'] ?? 'unity';
            $request['current_quantity'] = $request['current_quantity'] ?? 0;
            $data = $request->all();
            $imagePath = $request->file('image')?->store('ItemsInStock/images', 'public') ?? null;
            $data['image'] = $imagePath;
            $itemInStock->update($data);
            //TODO: Redirecionar para outra rota.
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemInStock $itemInStock)
    {
        try
        {
            $itemInStock->delete();
            //TODO: Redirecionar para outra rota.
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }
}
