<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Book::with(['bookType', 'authors'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'BookTitle'   => 'required|string|max:255',
            'BookTypeID'  => 'required|integer|exists:tblBookType,BookTypeID',
            'PublishDate' => 'nullable|date',
            'NumOfPages'  => 'nullable|integer|min:1',
            'NumOfCopies' => 'nullable|integer|min:0',
            'Edition'     => 'nullable|string|max:50',
            'Publisher'   => 'nullable|string|max:150',
            'BookSource'  => 'nullable|string|max:150',
            'Remark'      => 'nullable|string|max:255',
        ]);

        $book = Book::create($data);

        return response()->json($book->load('bookType'), 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(Book::with(['bookType', 'authors'])->findOrFail($id));
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'BookTitle'   => 'sometimes|required|string|max:255',
            'BookTypeID'  => 'sometimes|required|integer|exists:tblBookType,BookTypeID',
            'PublishDate' => 'nullable|date',
            'NumOfPages'  => 'nullable|integer|min:1',
            'NumOfCopies' => 'nullable|integer|min:0',
            'Edition'     => 'nullable|string|max:50',
            'Publisher'   => 'nullable|string|max:150',
            'BookSource'  => 'nullable|string|max:150',
            'Remark'      => 'nullable|string|max:255',
        ]);

        $book->update($data);

        return response()->json($book->load('bookType'));
    }

    public function destroy(string $id): JsonResponse
    {
        Book::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}