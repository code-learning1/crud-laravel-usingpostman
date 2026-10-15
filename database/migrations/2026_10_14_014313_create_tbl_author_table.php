<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblAuthor', function (Blueprint $table) {
            $table->id('AuthorID');
            $table->string('AuthorName', 150);
            $table->string('Gender', 10)->nullable();
            $table->date('DOB')->nullable();
            $table->string('POB', 150)->nullable();
            $table->string('Address', 255)->nullable();
            $table->string('Phone', 30)->nullable();
            $table->string('Email', 150)->nullable();
            $table->string('Photo', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblAuthor');
    }
};