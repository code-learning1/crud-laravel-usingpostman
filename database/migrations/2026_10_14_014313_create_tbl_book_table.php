<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblBook', function (Blueprint $table) {
            $table->id('BookID');
            $table->string('BookTitle', 255);
            $table->unsignedBigInteger('BookTypeID');
            $table->date('PublishDate')->nullable();
            $table->unsignedInteger('NumOfPages')->nullable();
            $table->unsignedInteger('NumOfCopies')->default(0);
            $table->string('Edition', 50)->nullable();
            $table->string('Publisher', 150)->nullable();
            $table->string('BookSource', 150)->nullable();
            $table->string('Remark', 255)->nullable();

            $table->foreign('BookTypeID')->references('BookTypeID')->on('tblBookType');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblBook');
    }
};