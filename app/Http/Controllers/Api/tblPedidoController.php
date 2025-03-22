<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblPedido;
use App\Models\tblColocacion;
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
        $validated = $request->validated();

        // Check if a pedido already exists for the same factura + colocacion
        $pedido = tblPedido::where('factura_id', $validated['factura_id'])
        ->where('colocacion_id', $validated['colocacion_id'])
        ->first();

        if ($pedido) {
            // Merge quantities
            $pedido->cantidad += $validated['cantidad'];
            $pedido->save();
        } else {
            $pedido = tblPedido::create($validated);
        }
        
        // Reduce stock in tblColocacion
        $colocacion = tblColocacion::find($validated['colocacion_id']);
        $colocacion->cantidad_en_stock -= $validated['cantidad'];
        $colocacion->save();

        return response()->json($pedido, 201);
    }

    public function show(tblPedido $pedido): JsonResponse {
        return response()->json($pedido);
    }

    public function update(UpdatePedidoRequest $request, tblPedido $pedido): JsonResponse {
        $validated = $request->validated();
        $oldCantidad = $pedido->cantidad;
        $oldColocacionId = $pedido->colocacion_id;

        $pedido->update($validated);

        // If colocacion_id changed, adjust both old and new stocks
        if (isset($validated['colocacion_id']) && $validated['colocacion_id'] != $oldColocacionId) {
            $oldColocacion = tblColocacion::find($oldColocacionId);
            $newColocacion = tblColocacion::find($validated['colocacion_id']);

            $oldColocacion->cantidad_en_stock += $oldCantidad;
            $oldColocacion->save();

            $newColocacion->cantidad_en_stock -= $pedido->cantidad;
            $newColocacion->save();
        } elseif (isset($validated['cantidad'])) {
            // If only cantidad changed, update stock difference
            $diff = $validated['cantidad'] - $oldCantidad;
            $colocacion = tblColocacion::find($pedido->colocacion_id);
            $colocacion->cantidad_en_stock -= $diff;
            $colocacion->save();
        }

        return response()->json($pedido);
    }

    public function destroy(tblPedido $pedido): JsonResponse {
        // If colcacion is destroyed, restore stock
        $colocacion = tblColocacion::find($pedido->colocacion_id);
        $colocacion->cantidad_en_stock += $pedido->cantidad;
        $colocacion->save();

        $pedido->delete();

        return response()->json(null, 204);
    }
}
