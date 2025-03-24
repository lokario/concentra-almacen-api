<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColocacionRequest;
use App\Http\Requests\UpdateColocacionRequest;
use App\Models\tblColocacion;
use App\Support\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class tblColocacionController extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblColocacion::query();

        if ($request->filled('lugar')) {
            $query->where('lugar', 'like', '%' . $request->lugar . '%');
        }

        $colocaciones = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'data'         => $colocaciones->items(),
            'total'        => $colocaciones->total(),
            'per_page'     => $colocaciones->perPage(),
            'current_page' => $colocaciones->currentPage(),
            'last_page'    => $colocaciones->lastPage(),
        ], 200);
    }

    public function store(StoreColocacionRequest $request): JsonResponse {
        $colocacion = tblColocacion::create($request->validated());
        return response()->json($colocacion, 201);
    }

    public function show(tblColocacion $colocacion): JsonResponse {
        return response()->json($colocacion);
    }

    public function update(UpdateColocacionRequest $request, tblColocacion $colocacion): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $colocacion->update($request->validated());
        return response()->json($colocacion);
    }

    public function destroy(tblColocacion $colocacion): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $colocacion->delete();
        return response()->json(null, 204);
    }
}
