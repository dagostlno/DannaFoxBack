<?php

namespace App\Http\Controllers;

use App\Models\sesionesModel;
use App\Models\usuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class usuariosController extends Controller
{
    protected $usuarioModel;
    protected $sesionModel;

    public function __construct(usuarioModel $usuarioModel, sesionesModel $sesionModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->sesionModel = $sesionModel;
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        $usuario = $this->usuarioModel->where('nombre_usuario', $validate['username'])->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario o contraseña incorrectos.'], 401);
        }

        if (!Hash::check($validate['password'], $usuario->contrasenia)) {
            return response()->json(['error' => 'Usuario o contraseña incorrectos.'], 401);
        }

        $token = $this->sesionModel->createToken([
            'id' => $usuario->idusuario,
            'name' => $usuario->nombre_usuario
        ]);

        return response()->json([
            'userid' => $usuario->idusuario,
            'expires-in' => 3600,
            'token' => $token
        ], 200);
    }
}
