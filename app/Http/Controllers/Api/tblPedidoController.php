<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblPedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\JsonResponse;

class tblPedidoController extends Controller {
    public function index(): JsonResponse {
        return response()->json(tblPedido::all(), 200);
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
