<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
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
        $peticion = Region::select($campos);

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
        $region = new Region();
        $region->nombre = $request->nombre;
        $region->codigo = $request->codigo;
        $region->save();

        $response['data'] = $region;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $relations = ['comunas'];
        $response['data'] = Region::where('id', $request->get('region_id'))->with($relations)->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|integer|exists_soft:regions,id',
            'nombre'    => 'nullable|string',
            'codigo'    => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $region = Region::where('id', $request->get('region_id'))->first();
        if ( $request->get('nombre') ) {
            $region->nombre = $request->get('nombre');
        }
        if ( $request->get('codigo') ) {
            $region->codigo = $request->get('codigo');
        }
        $region->update();

        $response['data'] = $region;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|integer|exists_soft:regions,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $region = Region::where('id', $request->get('region_id'))->first();
        $region->delete();

        return response()->json([
            'message' => "La región con id: ".$request->get('region_id')." fue borrada exitosamente.",
        ]);
    }
}
