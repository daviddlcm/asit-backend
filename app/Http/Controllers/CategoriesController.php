<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Displaies a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newlies created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'id_users' => 'required|exists:users,id_users'
        ]);
        $category = new Categories();
        $category->title = $validatedData['title'];
        $category->id_users = $validatedData['id_users'];
        $category->save();
        return response()->json(['message' => 'Categoria creado correctamente'], 201);
    }
    

    /**
     * Displaies the specified resource.
     */
    public function show($id_categories)
    {
        $categories = Categories::find($id_categories);
        return response()->json($categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_categories)
    {
        $update = DB::table("categories")
        ->where("id_categories", $id_categories)
        ->update([
            "title" => $request->title,
            "id_users"=>$request->id_users,
            "updated_at" => date("Y-m-d H:i:s")
        ]);
        if($update==0){
            $data = [
                "status" => 404,
                "message" => "Categoría No Encontrado"
            ];
            return response()->json($data);
        }
        $data = [
            "status" => 200,
            "message" => "Categoría actualizado",
            "data" => $update
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories, $id_categories)
    {
        $deleted = DB::table('categories')->where('id_categories', $id_categories)->delete();
        $data = [
            "status" => 404,
            "message" => "Categoría no encontrado"
        ];
        if($deleted==1){
            $data = [
                "status" => 200,
                "message" => "Categoría eliminado",
                "data" => $deleted
            ];
            return response()->json($data);
        }
        return response()->json($data);
    }
}
