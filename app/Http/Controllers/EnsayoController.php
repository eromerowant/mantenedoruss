<?php

namespace App\Http\Controllers;

use App\Ensayo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class EnsayoController extends Controller
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

        $campos = ['id', 'nombre', 'codigo', 'sede_id'];
        $peticion = Ensayo::select($campos);

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
            'nombre'  => 'required|string',
            'codigo'  => 'required|string',
            'sede_id' => 'required|integer|exists_soft:sedes,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $ensayo = new Ensayo();
        $ensayo->nombre    = $request->nombre;
        $ensayo->codigo    = $request->codigo;
        $ensayo->sede_id = $request->sede_id;
        $ensayo->save();

        $response['data'] = $ensayo;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'ensayo_id' => 'required|integer|exists_soft:ensayos,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Ensayo::where('id', $request->get('ensayo_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'ensayo_id' => 'required|integer|exists_soft:ensayos,id',
            'nombre'    => 'nullable|string',
            'codigo'    => 'nullable|string',
            'sede_id'   => 'nullable|integer|exists_soft:sedes,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $ensayo = Ensayo::where('id', $request->get('ensayo_id'))->first();
        if ( $request->get('nombre') ) {
            $ensayo->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $ensayo->codigo = $request->get('codigo');
        }
        if ( $request->get('sede_id') ) {
            $ensayo->sede_id = $request->get('sede_id');
        }
        $ensayo->update();

        $response['data'] = $ensayo;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'ensayo_id' => 'required|integer|exists_soft:ensayos,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $ensayo = Ensayo::where('id', $request->get('ensayo_id'))->first();
        $ensayo->delete();

        return response()->json([
            'message' => "El ensayo con id: ".$request->get('ensayo_id')." fue borrado exitosamente.",
        ]);
    }
}
