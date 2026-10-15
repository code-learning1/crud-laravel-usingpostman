<?php

namespace App\Http\Controllers;

use App\Models\BookType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookTypeController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(BookType::all());
    }


    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'BookTypeName' => 'required|string|max:100',
        ]);

        return response()->json(BookType::create($data), 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(BookType::findOrFail($id));
    }


    public function update(Request $request, string $id): JsonResponse
    {
        $bookType = BookType::findOrFail($id);

        $data = $request->validate([
            'BookTypeName' => 'sometimes|required|string|max:100',
        ]);

        $bookType->update($data);

        return response()->json($bookType);
    }


    public function destroy(string $id): JsonResponse
    {
        BookType::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}