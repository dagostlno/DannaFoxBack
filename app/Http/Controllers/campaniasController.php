<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\campaniaModel;
use App\Models\campanias_localidadesModel;
use App\Models\localidadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class campaniasController extends Controller
{
    public function index()
    {
        $campanias = campaniaModel::all();

        $data = [
            'campanias' => $campanias,
            'status' => '200',
            ];

            return response()->json($data, 200);
    }
    public function store(Request $request)
    {            
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required',        
            'texto_SMS'=> 'required',
            'cantidad_mensajes'=> 'required',
            'nombre_campania'=> 'required',
            'estado'=> 'required',
            'fecha_inicio'=> 'required'
            ]);
            if ($validator->fails()) {
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'satus' => 400
            ];
            return response()->json($data, 400);
        }    
           
           $campania = campaniaModel::create($request->all());
           
           foreach($request->campania_localidades as $value)
           {
              $results[] = array(
                  'id_campania' => $campania->campania_id,
                  'id_localidad' => $value['id_localidad']);                           
            }
                    
            $campania->campania_localidad()->createMany($results);

            // $camp = campaniaModel::select('campanias.*','campanias_localidades.*')
            //         ->join('campanias_localidades','id_campania','=','campanias.campania_id')
            //         ->where('campanias.campania_id','=', $campania->campania_id)
            //         ->get();
            
            $campania->push( $campania->campania_localidad); 

            $data = [
              'campania' => $campania,                                    
              'status' => 201
            ];
            
            return response()->json($data, 201);
        }
    public function show($id)
    {
        
        // $campania = campaniaModel::select('campanias.*','campanias_localidades.*','localidades.*')
        //         ->join('campanias_localidades','id_campania','=','campanias.campania_id')
        //         ->join('localidades','localidad_id',"=",'campanias_localidades.id_localidad')
        //         ->where('campanias.campania_id','=', $id)
        //         ->get();
        
        $campania = campaniaModel::getSingle($id);       
        $campania->push( $campania->campania_localidad); 
              
        if (!$campania) { 
        $data = [
            'message' => 'Campania no Encontrada',
            'status'=> 404
            ];
            return response()->json($data, 404);
        }
                $data = [
                    'campania' => $campania,
                    'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $campania = campaniaModel::getSingle($id);
      
        if (!$campania) {
            $data = [
                'message'=> 'Campania no encontrada',
                'status'=> 404
            ];
                return response()->json($data, 404);
        }
       
         $campania::where('campania_id', $id)->delete();

        $data = [
            'message'=> 'Campania eliminada',
            'status'=> 200
            ];

           return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $campania = campaniaModel::getSingle($id);
              
        if (!$campania) {
            $data = [
                'message'=> 'Campania no encontrada',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required',
            'localidad_id' => 'required',
            'texto_SMS'=> 'required',
            'cantidad_mensajes'=> 'required',
            'nombre_campania'=> 'required',
            'estado' => 'required',
            'fecha_inicio'=> 'required'                       
        ]);
              
        if ($validator->fails()) { 
            $data = [
                'message'=> 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }       

        $campania->cliente_id = $request->cliente_id;
        $campania->localidad_id = $request->localidad_id;
        $campania->texto_SMS = $request->texto_SMS;
        $campania->cantidad_mensajes = $request->cantidad_mensajes;
        $campania->nombre_campania = $request->nombre_campania;
        $campania->estado = $request->estado;
        $campania->fecha_inicio = $request->fecha_inicio;

        $campania->save();
        
        $data = [
            'message'=> 'Campania Actualizada',
            'campania'=> $campania,
            'status'=> 200
            ];
            
            return response()->json($data, 200);
        }
    }
   