<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUsersEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->user()->id_user_role == 1){
            $users = User::all();
            $data = [
                "status" => 200,
                "message" => "Listado de usuarios",
                "data" => $users
            ];
            return response()->json($data);
        }else{
            $data = [
                "status" => 401,
                "message" => "No tienes permisos para acceder a esta información"
            ];
            return response()->json($data);
        }
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
        if($request->user()->id_user_role == 1){
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $passwordRandom = $this->createdPasswordRandom();
        $user->password = $passwordRandom;
        $user->id_user_role = 2;        

        Mail::to($user->email)->send(new RegisterUsersEmail($user, $passwordRandom));
        $user->save();

        $data = [
            "status" => 201,
            "message" => "Usuario creado correctamente",
            "data" => $user,
            "password" => $passwordRandom
        ];
        return response()->json($data);
        }else{
        $data = [
            "status" => 401,
            "message" => "No tienes permisos para acceder a esta información"
        ];
        return response()->json($data);
        }
    }
    public function storeSuperAdmin(Request $request){
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            //$passwordRandom = $this->createdPasswordRandom();
            //$user->password = $passwordRandom;
            $user->password = $request->password;
            $user->id_user_role = 1;        
    
            //Mail::to($user->email)->send(new RegisterUsersEmail($user, $passwordRandom));
            $user->save();
    
            $data = [
                "status" => 201,
                "message" => "Usuario creado correctamente",
                "data" => $user,
                //"password" => $passwordRandom
            ];
            return response()->json($data);
    }

    public function createdPasswordRandom(){
        $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        return $password;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
        if($request->user()->id_user_role == 1){
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
        }else{
            $data = [
                "status" => 401,
                "message" => "No tienes permisos para acceder a esta información"
            ];
            return response()->json($data);
        }
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
        if($request->user()->id_user_role == 1){
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
        }else{
            $data = [
                "status" => 401,
                "message" => "No tienes permisos para acceder a esta información"
            ];
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        if($request->user()->id_user_role == 1){
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
        }else{
            $data = [
                "status" => 401,
                "message" => "No tienes permisos para acceder a esta información"
            ];
            return response()->json($data);
        }
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
                "message" => "Password de usuario actualizado",
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
            "message" => "Usuario encontrado, logeado correctamente",
            "data" => $user,
            "token" => $token 
        ];
        
        return response()->json($data);
    }

    public function logOut(Request $request){
        $request->user()->currentAccessToken()->delete();
        $data = [
            "status" => 200,
            "message" => "Usuario deslogeado correctamente"
        ];
        return response()->json($data);
    }
}
