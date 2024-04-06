<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Products::all();
        return response()->json($product);
        //
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

           $validatedData = $request->validate([
            'name' => 'required|max:255',
            'model' => 'required|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'mark' => 'required|max:255',
            'id_categories' => 'required|exists:categories,id_categories',
            'id_users' => 'required|exists:users,id_users',
        ]);

        $product = new Products();
        $product->name = $validatedData['name'];
        $product->model = $validatedData['model'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->mark = $validatedData['mark'];
        $product->id_categories = $validatedData['id_categories'];
        $product->id_users = $validatedData['id_users'];
        $product->save();
        return response()->json(['message' => 'Producto creado correctamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
    
    }

    public function productsByCategory($id_categories)
    {
        $product = Products::find($id_categories);    
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'No Existen Productos Para esta categoría'], 404);
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        //
    }
}
