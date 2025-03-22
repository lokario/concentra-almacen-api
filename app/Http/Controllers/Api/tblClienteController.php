<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tblCliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\JsonResponse;

class tblClienteController extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblCliente::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $perPage = $request->input('per_page', 12);
        $clientes = $query->paginate($perPage);

        return response()->json([
            'data' => $clientes->items(),
            'total' => $clientes->total(),
            'per_page' => $clientes->perPage(),
            'current_page' => $clientes->currentPage(),
            'last_page' => $clientes->lastPage(),
        ], 200);
    }

    public function store(StoreClienteRequest $request): JsonResponse {
        $cliente = tblCliente::create($request->validated());

        return response()->json($cliente, 201);
    }

    public function show(tblCliente $cliente): JsonResponse {
        return response()->json($cliente);
    }

    public function update(UpdateClienteRequest $request, tblCliente $cliente): JsonResponse {
        if (auth()->user()->rol !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        
        $cliente->update($request->validated());

        return response()->json($cliente);
    }

    public function destroy(tblCliente $cliente): JsonResponse {
        if (auth()->user()->rol !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $cliente->delete();

        return response()->json(null, 204);
    }
}
