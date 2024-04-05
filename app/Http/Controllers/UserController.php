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
            "data" => $user
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = DB::table('users')
             ->select(DB::raw('*'))
             ->where("id_users", $id)
             ->get();
        if($users->isEmpty()){
            $data = [
                "status" => 404,
                "message" => "Usuario no encontrado"
            ];
            return response()->json($data);
        }
        $data = [
            "status" => 200,
            "message" => "Usuario encontrado",
            "data" => $users
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
    public function update(Request $request, string $id)
    {
        $update = DB::table("users")
            ->where("id_users", $id)
            ->update([
                "username" => $request->username,
                "email" => $request->email,
                "password" => $request->password,
                "updated_at" => date("Y-m-d H:i:s")
            ]);
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
    public function destroy(string $id)
    {
        $deleted = DB::table('users')->where('id_users', $id)->delete();
        $data = [
            "status" => 404,
            "message" => "Usuario no encontrado"
        ];
        if($deleted==1){
            $data = [
                "status" => 200,
                "message" => "Usuario eliminado",
                "data" => $deleted
            ];
            return response()->json($data);
        }
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
