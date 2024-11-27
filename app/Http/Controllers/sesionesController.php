<?php

namespace App\Http\Controllers;

use App\Models\sesionesModel;
use App\Models\usuarioModel;
use Illuminate\Http\Request;

class sesionesController extends Controller
{
    protected $sesionModel;

    public function __construct(usuarioModel $usuarioModel, sesionesModel $sesionModel)
    {
        $this->sesionModel = $sesionModel;
    }


    public function auth(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token no proporcionado',
            ], 400);
        }

        $sesionesModel = new sesionesModel();

        // Validar el token
        $isValid = $sesionesModel->authToken($token);

        if ($isValid) {
            return response()->json([
                'success' => true,
                'message' => 'Token válido',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Token inválido o expirado',
        ], 401);
    }

}
