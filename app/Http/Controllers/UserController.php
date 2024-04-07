<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        $data = [
            "status" => 200,
            "message" => "Listado de usuarios",
            "data" => $users
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->id_user_role = $request-> id_user_role;
        $user->save();
        $data = [
            "status" => 201,
            "message" => "Usuario creado correctamente",
            "data" => $user,
            "usuarioQueLoCreo" => $request->user()
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            $data = [
                "status" => 404,
                "message" => "Usuario no encontrado"
            ];
            return response()->json($data);
        }
        $data = [
            "status" => 200,
            "message" => "Usuario encontrado",
            "data" => $user
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
            $update = User::find($id);
            $update->username = $request->username;
            $update->email = $request->email;
            $update->password = $request->password;
            $update->updated_at = now();
            $update->save();

            if($update==0){
                $data = [
                    "status" => 404,
                    "message" => "Usuario no encontrado"
                ];
                return response()->json($data);
            }
            $data = [
                "status" => 200,
                "message" => "Usuario actualizado",
                "data" => $update
            ];
            return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = [
            "status" => 404,
            "message" => "Usuario no encontrado"
        ];
        $user = User::destroy($id);
        if($user==1){
            $data = [
                "status" => 200,
                "message" => "Usuario eliminado",
                "data" => $user
            ];
            return response()->json($data);
        }
        return response()->json($data);
    }


    public function updatePassword(Request $request,$userId){
            $user = User::find($userId);
            if(!$user){
                $data = [
                    "status" => 404,
                    "message" => "Usuario no encontrado"
                ];
                return response()->json($data);
            }
            $user->password = $request->password;
            $user->updated_at = now();
            $user->save();
            $data = [
                "status" => 200,
                "message" => "Usuario actualizado",
                "data" => $user
            ];
            return response()->json($data);
    }

    public function logIn(Request $request){
        $user = User::where("email", $request->email)->first();
        if(!$user){
            $data = [
                "status" => 404,
                "message" => "Usuario no encontrado"
            ];
            return response()->json($data);
        }
        if(! Hash::check($request->password, $user->password)){
            $data = [
                "status" => 404,
                "message" => "Usuario no encontrado"
            ];
            return response()->json($data);
        }
        $token = $user->createToken("myToken")->plainTextToken;
        $data = [
            "status" => 200,
            "message" => "Usuario encontrado",
            "data" => $user,
            "token" => $token 
        ];
        
        return response()->json($data);
    }
}
