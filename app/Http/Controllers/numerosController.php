<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\numeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class numerosController extends Controller
{
    public function index()
    {
        $numeros = numeroModel::all();

        $data = [
            'numeros' => $numeros,
            'status' => '200',
            ];

            return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required',
            'localidad_id' => 'required',
            ]);
            if ($validator->fails()) {
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'satus' => 400
            ];
            return response()->json($data, 400);
        }    
        $numero = numeroModel::create ([
            
            'numero' => $request ->numero,
            'localidad_id' => $request ->localidad_id,
            ]);

            if (! $numero) {
                $data = [
                    'message'=> 'Error al crear el numero',
                    'status'=> 500
                    ];
                    return response()->json($data, 500);
    }
            $data = [
              'numero' => $numero,
              'status' => 201
            ];
            
            return response()->json($data, 201);
        }
    public function show($id)
    {
        $numero =  $numero = numeroModel::getSingle($id);


        if (!$numero) { 
        $data = [
            'message' => 'Numero no Encontrado',
            'status'=> 404
            ];
            return response()->json($data, 404);
        }
                $data = [
                    'numero' => $numero,
                    'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $numero = numeroModel::getSingle($id);
      
        if (!$numero) {
            $data = [
                'message'=> 'Numero no encontrado',
                'status'=> 404
            ];
                return response()->json($data, 404);
        }
       
         $numero::where('numero_id', $id)->delete();

        $data = [
            'message'=> 'Numero eliminado',
            'status'=> 200
            ];

           return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $numero = numeroModel::getSingle($id);
              
        if (!$numero) {
            $data = [
                'message'=> 'Numero no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'numero' => 'required',
            'localidad_id' => 'required',                      
        ]);
              
        if ($validator->fails()) { 
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }       

        $numero->numero = $request->numero;
        $numero->localidad_id = $request->localidad_id;

        $numero->save();
        
        $data = [
            'message'=> 'Numero Actualizado',
            'numero'=> $numero,
            'status'=> 200
            ];
            
            return response()->json($data, 200);
        }
    }
   