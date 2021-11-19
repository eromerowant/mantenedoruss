<?php

namespace App\Http\Controllers;

use App\Sede;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class SedeController extends Controller
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

        $campos = ['id', 'nombre', 'region_id'];
        $peticion = Sede::select($campos);

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
            'region_id' => 'required|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $sede = new Sede();
        $sede->nombre    = $request->nombre;
        $sede->region_id = $request->region_id;
        $sede->save();

        $response['data'] = $sede;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'sede_id' => 'required|integer|exists_soft:sedes,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Sede::where('id', $request->get('sede_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'sede_id'   => 'required|integer|exists_soft:sedes,id',
            'nombre'    => 'nullable|string',
            'region_id' => 'nullable|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $sede = Sede::where('id', $request->get('sede_id'))->first();
        if ( $request->get('nombre') ) {
            $sede->nombre = $request->get('nombre');
        }
        if ( $request->get('region_id') ) {
            $sede->region_id = $request->get('region_id');
        }
        $sede->update();

        $response['data'] = $sede;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'sede_id' => 'required|integer|exists_soft:sedes,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $sede = Sede::where('id', $request->get('sede_id'))->first();
        $sede->delete();

        return response()->json([
            'message' => "La sede con id: ".$request->get('sede_id')." fue borrada exitosamente.",
        ]);
    }
}
