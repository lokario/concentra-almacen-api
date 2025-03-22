<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblArticulo;
use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use Illuminate\Http\JsonResponse;

class tblArticuloController extends Controller {
    public function index(): JsonResponse {
        return response()->json(tblArticulo::all(), 200);
    }

    public function store(StoreArticuloRequest $request): JsonResponse {
        $articulo = tblArticulo::create($request->validated());
        return response()->json($articulo, 201);
    }

    public function show(tblArticulo $articulo): JsonResponse {
        return response()->json($articulo);
    }

    public function update(UpdateArticuloRequest $request, tblArticulo $articulo): JsonResponse {
        $articulo->update($request->validated());
        return response()->json($articulo);
    }

    public function destroy(tblArticulo $articulo): JsonResponse {
        $articulo->delete();
        return response()->json(null, 204);
    }
}
