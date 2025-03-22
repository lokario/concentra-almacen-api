<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tblCliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\JsonResponse;

class tblClienteController extends Controller {
    public function index(): JsonResponse {
        $customers = tblCliente::all();

        return response()->json($customers, 200);
    }

    public function store(StoreClienteRequest $request): JsonResponse {
        $cliente = tblCliente::create($request->validated());

        return response()->json($cliente, 201);
    }

    public function show(tblCliente $cliente): JsonResponse {
        return response()->json($cliente);
    }

    public function update(UpdateClienteRequest $request, tblCliente $cliente): JsonResponse {
        $cliente->update($request->validated());

        return response()->json($cliente);
    }

    public function destroy(tblCliente $cliente): JsonResponse {
        $cliente->delete();

        return response()->json(null, 204);
    }
}
