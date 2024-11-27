<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\clienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class clientesController extends Controller
{
    public function index()
    {
        $clientes = clienteModel::all();

        $data = [
            'clientes' => $clientes,
            'status' => '200',
            ];

            return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razon_social'=> 'required|max:255',
            'cuil_cuit'=> 'required|unique:clientes|max:25',
            'apellido'=> 'required',
            'nombre'=> 'required',
            'telefono'=> 'required|max:20',
            'email'=> 'required|email|unique:clientes',
            ]);
            if ($validator->fails()) {
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'satus' => 400
            ];
            return response()->json($data, 400);
        }    
        $cliente = clienteModel::create ([
            
            'razon_social'=> $request->razon_social,
            'cuil_cuit'=> $request->cuil_cuit,
            'apellido'=> $request->apellido,
            'nombre' => $request->nombre,
            'telefono'=> $request->telefono,
            'email' => $request->email
            ]);

            if (! $cliente) {
                $data = [
                    'message'=> 'Error al crear el Cliente',
                    'status'=> 500
                    ];
                    return response()->json($data, 500);
    }
            $data = [
              'cliente' => $cliente,
              'status' => 201
            ];
            
            return response()->json($data, 201);
        }
    public function show($id)
    {
        $cliente =  $cliente = clienteModel::getSingle($id);


        if (!$cliente) { 
        $data = [
            'message' => 'Cliente no Encontrado',
            'status'=> 404
            ];
            return response()->json($data, 404);
        }
                $data = [
                    'cliente' => $cliente,
                    'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $cliente = clienteModel::getSingle($id);
      
        if (!$cliente) {
            $data = [
                'message'=> 'Cliente no encontrado',
                'status'=> 404
            ];
                return response()->json($data, 404);
        }
       
         $cliente::where('cliente_id', $id)->delete();

        $data = [
            'message'=> 'Cliente eliminado',
            'status'=> 200
            ];

           return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $cliente = clienteModel::getSingle($id);
              
        if (!$cliente) {
            $data = [
                'message'=> 'Cliente no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'razon_social'=> 'required|max:255',
            'cuil_cuit'=> 'required|max:13|unique:clientes,cuil_cuit,'.$id.',cliente_id',
            'apellido'=> 'required',
            'nombre'=> 'required',
            'telefono'=> 'required|max:20',
            'email'=> 'required|email|unique:clientes,email,'.$id.',cliente_id'                          
        ]);
              
        if ($validator->fails()) { 
            $data = [
                'message'=> 'Error en la validaicon de los datos',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }       

        $cliente->razon_social = $request->razon_social;
        $cliente->cuil_cuit = $request->cuil_cuit;
        $cliente->apellido = $request->apellido;
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;

        $cliente->save();
        
        $data = [
            'message'=> 'Cliente Actualizado',
            'cliente'=> $cliente,
            'status'=> 200
            ];
            
            return response()->json($data, 200);
        }
    }
   