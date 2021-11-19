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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Region $region)
    {
        //
    }

    public function edit(Region $region)
    {
        //
    }

    public function update(Request $request, Region $region)
    {
        //
    }

    public function destroy(Region $region)
    {
        //
    }
}
