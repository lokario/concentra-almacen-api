<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tblPY1;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class tblPY1Controller extends Controller {
    public function index(Request $request): JsonResponse {
        $query = tblPY1::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('cedula')) {
            $query->where('cedula', $request->cedula);
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        $usuarios = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'data' => $usuarios->items(),
            'total' => $usuarios->total(),
            'per_page' => $usuarios->perPage(),
            'current_page' => $usuarios->currentPage(),
            'last_page' => $usuarios->lastPage()
        ], 200);
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
