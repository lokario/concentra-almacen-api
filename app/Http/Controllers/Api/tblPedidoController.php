<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\tblColocacion;
use App\Models\tblPedido;
use App\Support\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'data'         => $pedidos->items(),
            'total'        => $pedidos->total(),
            'per_page'     => $pedidos->perPage(),
            'current_page' => $pedidos->currentPage(),
            'last_page'    => $pedidos->lastPage(),
        ], 200);
    }

    public function store(StorePedidoRequest $request): JsonResponse {
        $validated  = $request->validated();
        $colocacion = tblColocacion::with('articulo')->findOrFail($validated['colocacion_id']);
        $articulo   = $colocacion->articulo;

        if ($articulo->stock < $validated['cantidad']) {
            return response()->json([
                'message' => 'No hay suficiente stock para este artículo.',
            ], 400);
        }

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
        $articulo->stock -= $validated['cantidad'];
        $articulo->save();

        return response()->json($pedido, 201);
    }

    public function show(tblPedido $pedido): JsonResponse {
        return response()->json($pedido);
    }

    public function update(UpdatePedidoRequest $request, tblPedido $pedido): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validated = $request->validated();

        $oldColocacion = tblColocacion::with('articulo')->findOrFail($pedido->colocacion_id);
        $newColocacion = tblColocacion::with('articulo')->findOrFail($validated['colocacion_id']);

        $oldArticulo = $oldColocacion->articulo;
        $newArticulo = $newColocacion->articulo;

        $oldCantidad = $pedido->cantidad;
        $newCantidad = $validated['cantidad'];

        // If artículo is the same, we only need to handle stock difference
        if ($oldArticulo->id === $newArticulo->id) {
            $diferencia = $newCantidad - $oldCantidad;

            if ($diferencia > 0 && $newArticulo->stock < $diferencia) {
                return response()->json([
                    'message' => 'No hay suficiente stock para aumentar la cantidad.',
                ], 400);
            }

            $newArticulo->stock -= $diferencia;
            $newArticulo->save();
        } else {
            // Different artículos — restore stock to old, reduce from new
            if ($newArticulo->stock < $newCantidad) {
                return response()->json([
                    'message' => 'No hay suficiente stock en el nuevo artículo.',
                ], 400);
            }

            $oldArticulo->stock += $oldCantidad;
            $newArticulo->stock -= $newCantidad;

            $oldArticulo->save();
            $newArticulo->save();
        }

        $pedido->update($validated);

        return response()->json($pedido);
    }

    public function destroy(tblPedido $pedido): JsonResponse {
        if (auth()->user()->rol !== Constants::ROL_ADMIN) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // If pedido is destroyed, restore stock
        $articulo = $pedido->colocacion->articulo;
        $articulo->stock += $pedido->cantidad;
        $articulo->save();

        $pedido->delete();

        return response()->json(null, 204);
    }
}
