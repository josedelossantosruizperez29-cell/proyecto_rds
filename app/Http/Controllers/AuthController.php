<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // controlador que nos permitira autenticar los usuarios y registrarlos
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        //eliminamos unos tokens anteriores del usuario autenticado esto con el fin de que no se dupliquen o se alamcenen tokens anteriores
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['message' => 'Login exitoso', 'token' => $token, 'user' => $user, 'mensaje' => 'Bienvenido: '.$user->name], 200);
    }

    public function register(Request $request){
        // aqui registramos un nuevo usuario
         $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['message' => 'El usuario ya existe'], 401);
        }
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $token = $user->createToken('api-token')->plainTextToken;
       return response([
           'message' => 'Usuario creado correctamente',
           'user' => $user,
           'token' => $token
       ]);
        
    }

    public function logout(Request $request){
        // aqui cerramos la sesion del usuario y eliminamos el token del usuario que cerro la sesion esto con el fin de que no puedan hacer consultas despues de cerrar la sesion

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout exitoso'], 200);
        
    }
}

