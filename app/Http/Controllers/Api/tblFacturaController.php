<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblFactura;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFacturaRequest;
use App\Http\Requests\UpdateFacturaRequest;
use Illuminate\Http\JsonResponse;

class tblFacturaController extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblFactura::query();

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('fecha', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('fecha', '<=', $request->to);
        }

        $facturas = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'data' => $facturas->items(),
            'total' => $facturas->total(),
            'per_page' => $facturas->perPage(),
            'current_page' => $facturas->currentPage(),
            'last_page' => $facturas->lastPage()
        ], 200);
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
