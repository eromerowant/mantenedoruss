<?php

namespace App\Http\Controllers;

use App\Carrera;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CarreraController extends Controller
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
        $peticion = Carrera::select($campos);

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
        $origen = new Carrera();
        $origen->nombre = $request->nombre;
        $origen->codigo = $request->codigo;
        $origen->save();

        $response['data'] = $origen;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'carrera_id' => 'required|integer|exists_soft:carreras,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Carrera::where('id', $request->get('carrera_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'carrera_id' => 'required|integer|exists_soft:carreras,id',
            'nombre'     => 'nullable|string',
            'codigo'     => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $carrera = Carrera::where('id', $request->get('carrera_id'))->first();
        if ( $request->get('nombre') ) {
            $carrera->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $carrera->codigo = $request->get('codigo');
        }
        $carrera->update();

        $response['data'] = $carrera;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'carrera_id' => 'required|integer|exists_soft:carreras,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $carrera = Carrera::where('id', $request->get('carrera_id'))->first();
        $carrera->delete();

        return response()->json([
            'message' => "La carrera con id: ".$request->get('carrera_id')." fue borrada exitosamente.",
        ]);
    }
}
