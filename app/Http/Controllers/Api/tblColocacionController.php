<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblColocacion;
use App\Http\Requests\StoreColocacionRequest;
use App\Http\Requests\UpdateColocacionRequest;
use Illuminate\Http\JsonResponse;

class tblColocacionController extends Controller {
    public function index(): JsonResponse {
        return response()->json(tblColocacion::all(), 200);
    }

    public function store(StoreColocacionRequest $request): JsonResponse {
        $colocacion = tblColocacion::create($request->validated());
        return response()->json($colocacion, 201);
    }

    public function show(tblColocacion $colocacion): JsonResponse {
        return response()->json($colocacion);
    }

    public function update(UpdateColocacionRequest $request, tblColocacion $colocacion): JsonResponse {
        $colocacion->update($request->validated());
        return response()->json($colocacion);
    }

    public function destroy(tblColocacion $colocacion): JsonResponse {
        $colocacion->delete();
        return response()->json(null, 204);
    }
}
