<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblPedido;
use Illuminate\Http\Request;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\JsonResponse;

class tblPedidoController extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblPedido::query();

        if ($request->filled('factura_id')) {
            $query->where('factura_id', $request->factura_id);
        }

        if ($request->filled('colocacion_id')) {
            $query->where('colocacion_id', $request->colocacion_id);
        }

        $pedidos = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'data' => $pedidos->items(),
            'total' => $pedidos->total(),
            'per_page' => $pedidos->perPage(),
            'current_page' => $pedidos->currentPage(),
            'last_page' => $pedidos->lastPage()
        ], 200);
    }

    public function store(StorePedidoRequest $request): JsonResponse {
        $pedido = tblPedido::create($request->validated());
        return response()->json($pedido, 201);
    }

    public function show(tblPedido $pedido): JsonResponse {
        return response()->json($pedido);
    }

    public function update(UpdatePedidoRequest $request, tblPedido $pedido): JsonResponse {
        $pedido->update($request->validated());
        return response()->json($pedido);
    }

    public function destroy(tblPedido $pedido): JsonResponse {
        $pedido->delete();
        return response()->json(null, 204);
    }
}
