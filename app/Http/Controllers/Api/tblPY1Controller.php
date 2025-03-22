<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblPY1;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class tblPY1Controller extends Controller {
    public function index(): JsonResponse {
        return response()->json(tblPY1::all(), 200);
    }

    public function store(StoreUsuarioRequest $request): JsonResponse {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $usuario = tblPY1::create($data);
        return response()->json($usuario, 201);
    }

    public function show(tblPY1 $usuario): JsonResponse {
        return response()->json($usuario);
    }

    public function update(UpdateUsuarioRequest $request, tblPY1 $usuario): JsonResponse {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $usuario->update($data);
        return response()->json($usuario);
    }

    public function destroy(tblPY1 $usuario): JsonResponse {
        $usuario->delete();
        return response()->json(null, 204);
    }
}
