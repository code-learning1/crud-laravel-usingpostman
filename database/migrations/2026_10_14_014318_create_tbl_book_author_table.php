<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblBookAuthor', function (Blueprint $table) {
            $table->unsignedBigInteger('BookID');
            $table->unsignedBigInteger('AuthorID');
            $table->date('AuthorDate')->nullable();
            $table->string('Remark', 255)->nullable();

            $table->primary(['BookID', 'AuthorID']);
            $table->foreign('BookID')->references('BookID')->on('tblBook')->cascadeOnDelete();
            $table->foreign('AuthorID')->references('AuthorID')->on('tblAuthor')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblBookAuthor');
    }
};