<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    
    public function index(): JsonResponse
    {
        return response()->json(Author::all());
    }


    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'AuthorName' => 'required|string|max:150',
            'Gender'     => 'nullable|string|max:10',
            'DOB'        => 'nullable|date',
            'POB'        => 'nullable|string|max:150',
            'Address'    => 'nullable|string|max:255',
            'Phone'      => 'nullable|string|max:30',
            'Email'      => 'nullable|email|max:150',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return response()->json(Author::create($data), 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(Author::with('books')->findOrFail($id));
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $author = Author::findOrFail($id);

        $data = $request->validate([
            'AuthorName' => 'sometimes|required|string|max:150',
            'Gender'     => 'nullable|string|max:10',
            'DOB'        => 'nullable|date',
            'POB'        => 'nullable|string|max:150',
            'Address'    => 'nullable|string|max:255',
            'Phone'      => 'nullable|string|max:30',
            'Email'      => 'nullable|email|max:150',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $author->update($data);

        return response()->json($author);
    }


    public function destroy(string $id): JsonResponse
    {
        Author::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}