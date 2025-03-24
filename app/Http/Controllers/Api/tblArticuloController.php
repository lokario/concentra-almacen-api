<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblArticulo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Support\Constants;
use Illuminate\Http\JsonResponse;

class tblArticuloController extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblArticulo::query();

        if ($request->filled('codigo_barras')) {
            $query->where('codigo_barras', 'like', '%' . $request->codigo_barras . '%');
        }

        if ($request->filled('fabricante')) {
            $query->where('fabricante', 'like', '%' . $request->fabricante . '%');
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->min_precio);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->max_precio);
        }

        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }

        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        $articulos = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'data' => $articulos->items(),
            'total' => $articulos->total(),
            'per_page' => $articulos->perPage(),
            'current_page' => $articulos->currentPage(),
            'last_page' => $articulos->lastPage()
        ], 200);
    }

    public function store(StoreArticuloRequest $request): JsonResponse {
        $articulo = tblArticulo::create($request->validated());
        return response()->json($articulo, 201);
    }

    public function show(tblArticulo $articulo): JsonResponse {
        return response()->json($articulo);
    }

    public function update(UpdateArticuloRequest $request, tblArticulo $articulo): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        
        $articulo->update($request->validated());
        return response()->json($articulo);
    }

    public function destroy(tblArticulo $articulo): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $articulo->delete();
        return response()->json(null, 204);
    }
}
