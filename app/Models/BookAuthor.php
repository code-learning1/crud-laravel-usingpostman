<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * tblBookAuthor has a composite primary key (BookID, AuthorID).
 * Eloquent does not support composite keys for find()/save(),
 * so the controller queries it with where() on both columns.
 */
class BookAuthor extends Model
{
    protected $table = 'tblBookAuthor';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['BookID', 'AuthorID', 'AuthorDate', 'Remark'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'BookID', 'BookID');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'AuthorID', 'AuthorID');
    }
}