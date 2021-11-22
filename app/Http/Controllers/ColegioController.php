<?php

namespace App\Http\Controllers;

use App\Colegio;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ColegioController extends Controller
{
    public function index( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'paginate' => 'nullable|integer|gte:1', // greater than or equal to 1.
            'nombre'   => 'nullable|string',
            'codigo'   => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $campos = ['id', 'nombre', 'codigo'];
        $peticion = Colegio::select($campos);

        // FILTROS
        if ( $request->get('nombre') ) {
            $peticion->where('nombre', 'like', "%".$request->get('nombre')."%");
        }

        if ( $request->get('codigo') ) {
            $peticion->where('codigo', 'like', "%".$request->get('codigo')."%");
        }

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
        $colegio = new Colegio();
        $colegio->nombre = $request->nombre;
        $colegio->codigo = $request->codigo;
        $colegio->save();

        $response['data'] = $colegio;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'colegio_id' => 'required|integer|exists_soft:colegios,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = Colegio::where('id', $request->get('colegio_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'colegio_id' => 'required|integer|exists_soft:colegios,id',
            'nombre'     => 'nullable|string',
            'codigo'     => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $colegio = Colegio::where('id', $request->get('colegio_id'))->first();
        if ( $request->get('nombre') ) {
            $colegio->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $colegio->codigo = $request->get('codigo');
        }
        $colegio->update();

        $response['data'] = $colegio;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'colegio_id' => 'required|integer|exists_soft:colegios,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $carrera = Colegio::where('id', $request->get('colegio_id'))->first();
        $carrera->delete();

        return response()->json([
            'message' => "El colegio con id: ".$request->get('colegio_id')." fue borrado exitosamente.",
        ]);
    }
}
