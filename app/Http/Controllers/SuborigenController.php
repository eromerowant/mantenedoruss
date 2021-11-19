<?php

namespace App\Http\Controllers;

use App\Suborigen;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class SuborigenController extends Controller
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

        $campos = ['id', 'nombre', 'codigo', 'origen_id'];
        $peticion = Suborigen::select($campos);

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
            'origen_id' => 'required|integer|exists_soft:origens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $suborigen = new Suborigen();
        $suborigen->nombre    = $request->nombre;
        $suborigen->codigo    = $request->codigo;
        $suborigen->origen_id = $request->origen_id;
        $suborigen->save();

        $response['data'] = $suborigen;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'suborigen_id' => 'required|integer|exists_soft:suborigens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Suborigen::where('id', $request->get('suborigen_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'suborigen_id' => 'required|integer|exists_soft:suborigens,id',
            'nombre'    => 'nullable|string',
            'codigo'    => 'nullable|string',
            'origen_id' => 'nullable|integer|exists_soft:origens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $suborigen = Suborigen::where('id', $request->get('suborigen_id'))->first();
        if ( $request->get('nombre') ) {
            $suborigen->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $suborigen->codigo = $request->get('codigo');
        }
        if ( $request->get('origen_id') ) {
            $suborigen->origen_id = $request->get('origen_id');
        }
        $suborigen->update();

        $response['data'] = $suborigen;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'suborigen_id' => 'required|integer|exists_soft:suborigens,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $suborigen = Suborigen::where('id', $request->get('suborigen_id'))->first();
        $suborigen->delete();

        return response()->json([
            'message' => "El suborigen con id: ".$request->get('suborigen_id')." fue borrado exitosamente.",
        ]);
    }
}
