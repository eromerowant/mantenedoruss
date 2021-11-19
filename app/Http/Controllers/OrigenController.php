<?php

namespace App\Http\Controllers;

use App\Origen;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class OrigenController extends Controller
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

        $campos = ['id', 'nombre', 'codigo'];
        $peticion = Origen::select($campos);

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
            'nombre' => 'required|string',
            'codigo' => 'required|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $origen = new Origen();
        $origen->nombre = $request->nombre;
        $origen->codigo = $request->codigo;
        $origen->save();

        $response['data'] = $origen;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'origen_id' => 'required|integer|exists_soft:origens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Origen::where('id', $request->get('origen_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'origen_id' => 'required|integer|exists_soft:origens,id',
            'nombre'    => 'nullable|string',
            'codigo'    => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $origen = Origen::where('id', $request->get('origen_id'))->first();
        if ( $request->get('nombre') ) {
            $origen->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $origen->codigo = $request->get('codigo');
        }
        $origen->update();

        $response['data'] = $origen;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'origen_id' => 'required|integer|exists_soft:origens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $origen = Origen::where('id', $request->get('origen_id'))->first();
        $origen->delete();

        return response()->json([
            'message' => "El origen con id: ".$request->get('origen_id')." fue borrado exitosamente.",
        ]);
    }
}
