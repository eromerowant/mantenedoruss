<?php

namespace App\Http\Controllers;

use App\Comuna;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ComunaController extends Controller
{
    public function index( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'paginate' => 'nullable|integer|gte:1' // greater than or equal to 1.
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $campos = ['id', 'nombre', 'codigo', 'region_id'];
        $peticion = Comuna::select($campos);

        // Con o sin paginación
        if ( $request->get('paginate') ) {
            $response = $peticion->paginate( $request->get('paginate') )->toArray();
        } else {
            $response['data'] = $peticion->get();
        }

        return response()->json($response);
    }

    public function store( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'nombre'    => 'required|string',
            'codigo'    => 'required|string',
            'region_id' => 'required|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $comuna = new Comuna();
        $comuna->nombre    = $request->nombre;
        $comuna->codigo    = $request->codigo;
        $comuna->region_id = $request->region_id;
        $comuna->save();

        $response['data'] = $comuna;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'comuna_id' => 'required|integer|exists_soft:comunas,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Comuna::where('id', $request->get('comuna_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'comuna_id' => 'required|integer|exists_soft:comunas,id',
            'nombre'    => 'nullable|string',
            'codigo'    => 'nullable|string',
            'region_id' => 'nullable|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $comuna = Comuna::where('id', $request->get('comuna_id'))->first();
        if ( $request->get('nombre') ) {
            $comuna->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $comuna->codigo = $request->get('codigo');
        }
        if ( $request->get('region_id') ) {
            $comuna->region_id = $request->get('region_id');
        }
        $comuna->update();

        $response['data'] = $comuna;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'comuna_id' => 'required|integer|exists_soft:comunas,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $comuna = Comuna::where('id', $request->get('comuna_id'))->first();
        $comuna->delete();

        return response()->json([
            'message' => "La comuna con id: ".$request->get('comuna_id')." fue borrada exitosamente.",
        ]);
    }
}
