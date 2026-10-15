<?php

namespace App\Http\Controllers;

use App\Models\BookAuthor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BookAuthorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(BookAuthor::with(['book', 'author'])->get());
    }


    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'BookID'     => 'required|integer|exists:tblBook,BookID',
            'AuthorID'   => 'required|integer|exists:tblAuthor,AuthorID',
            'AuthorDate' => 'nullable|date',
            'Remark'     => 'nullable|string|max:255',
        ]);

        $exists = BookAuthor::where('BookID', $data['BookID'])
            ->where('AuthorID', $data['AuthorID'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This book-author link already exists'], 422);
        }

        return response()->json(BookAuthor::create($data), 201);
    }

    public function show(string $bookId, string $authorId): JsonResponse
    {
        $row = BookAuthor::with(['book', 'author'])
            ->where('BookID', $bookId)
            ->where('AuthorID', $authorId)
            ->firstOrFail();

        return response()->json($row);
    }


    public function update(Request $request, string $bookId, string $authorId): JsonResponse
    {
        $query = BookAuthor::where('BookID', $bookId)->where('AuthorID', $authorId);
        $query->firstOrFail();

        $data = $request->validate([
            'AuthorDate' => 'nullable|date',
            'Remark'     => 'nullable|string|max:255',
        ]);

        $query->update($data);

        return response()->json($query->first());
    }


    public function destroy(string $bookId, string $authorId): JsonResponse
    {
        $query = BookAuthor::where('BookID', $bookId)->where('AuthorID', $authorId);
        $query->firstOrFail();
        $query->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}