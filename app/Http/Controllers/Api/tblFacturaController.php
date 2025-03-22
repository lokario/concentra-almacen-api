<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblFactura;
use App\Http\Requests\StoreFacturaRequest;
use App\Http\Requests\UpdateFacturaRequest;
use Illuminate\Http\JsonResponse;

class tblFacturaController extends Controller {
    public function index(): JsonResponse {
        return response()->json(tblFactura::all());
    }

    public function store(StoreFacturaRequest $request): JsonResponse {
        $factura = tblFactura::create($request->validated());
        return response()->json($factura, 201);
    }

    public function show(tblFactura $factura): JsonResponse {
        return response()->json($factura);
    }

    public function update(UpdateFacturaRequest $request, tblFactura $factura): JsonResponse {
        $factura->update($request->validated());
        return response()->json($factura);
    }

    public function destroy(tblFactura $factura): JsonResponse {
        $factura->delete();
        return response()->json(null, 204);
    }
}
