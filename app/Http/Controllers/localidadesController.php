<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\localidadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class localidadesController extends Controller
{
    public function index()
    {
        $localidades = localidadModel::all();

        $data = [
            'localidades' => $localidades,
            'status' => '200',
            ];

            return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'localidad'=> 'required'
            ]);
            if ($validator->fails()) {
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'satus' => 400
            ];
            return response()->json($data, 400);
        }    
        $localidad = localidadModel::create ([
            
            'localidad'=> $request->localidad,
            ]);

            if (! $localidad) {
                $data = [
                    'message'=> 'Error al crear la Localidad',
                    'status'=> 500
                    ];
                    return response()->json($data, 500);
    }
            $data = [
              'localidad' => $localidad,
              'status' => 201
            ];
            
            return response()->json($data, 201);
        }
    public function show($id)
    {
        $localidad =  $localidad = localidadModel::getSingle($id);


        if (!$localidad) { 
        $data = [
            'message' => 'Localidad no Encontrada',
            'status'=> 404
            ];
            return response()->json($data, 404);
        }
                $data = [
                    'localidad' => $localidad,
                    'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $localidad = localidadModel::getSingle($id);
      
        if (!$localidad) {
            $data = [
                'message'=> 'Localidad no encontrada',
                'status'=> 404
            ];
                return response()->json($data, 404);
        }
       
         $localidad::where('localidad_id', $id)->delete();

        $data = [
            'message'=> 'Localidad eliminada',
            'status'=> 200
            ];

           return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $localidad = localidadModel::getSingle($id);
              
        if (!$localidad) {
            $data = [
                'message'=> 'Localidad no encontrada',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'localidad'=> 'required'                        
        ]);
              
        if ($validator->fails()) { 
            $data = [
                'message'=> 'Error en la validaicon de los datos',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }       

        $localidad->localidad = $request->localidad;

        $localidad->save();
        
        $data = [
            'message'=> 'Localidad Actualizada',
            'localidad'=> $localidad,
            'status'=> 200
            ];
            
            return response()->json($data, 200);
        }
    }
   