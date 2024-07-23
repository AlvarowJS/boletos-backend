<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function authToken(Request $request)
    {
        $token = $request->header('Authorization');
        $user = Auth::user();
        $tableName = $user->getTable();
        $rol = $user->role->role_number;
        $user->role = $rol;
        $user->token = $token;
        $user->table = $tableName;
        return $user;
    }

    public function login(Request $request)
    {        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('email', 'password');     
                
        if (Auth::attempt($credentials)) {
            $user = Auth::user();          
            $name = $user->name;
            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                'api_token' => $token,
                'name' => $name,
                'rol' => $user->role_id

            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,            
            'password' => Hash::make($request->password),
            'role_id' => 1,    
            'phone' => $request->phone,
            'status' => true
        ]);
        return response()->json([
            'message' => 'Administrador creado exitosamente.',
            'user' => $user,
        ], 201);
    }
}
