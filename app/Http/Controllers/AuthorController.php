<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    // GET /api/authors
    public function index(): JsonResponse
    {
        return response()->json(Author::all());
    }

    // POST /api/authors
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
            'Photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('Photo')) {
            $data['Photo'] = $request->file('Photo')->store('photos', 'public');
        }

        return response()->json(Author::create($data), 201);
    }

    // GET /api/authors/{id}
    public function show(string $id): JsonResponse
    {
        return response()->json(Author::with('books')->findOrFail($id));
    }

    // PUT /api/authors/{id}  (or POST + _method=PUT for form-data)
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
            'Photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('Photo')) {
            // remove the old picture, then save the new one
            if ($author->Photo) {
                Storage::disk('public')->delete($author->Photo);
            }
            $data['Photo'] = $request->file('Photo')->store('photos', 'public');
        } else {
            // no new file sent: keep the existing photo
            unset($data['Photo']);
        }

        if (!empty($data)) {
            $author->update($data);
        }

        return response()->json($author->fresh());
    }

    // DELETE /api/authors/{id}
    public function destroy(string $id): JsonResponse
    {
        $author = Author::findOrFail($id);

        if ($author->Photo) {
            Storage::disk('public')->delete($author->Photo);
        }

        $author->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}