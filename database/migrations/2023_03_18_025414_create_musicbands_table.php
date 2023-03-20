<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('musicbands', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name', 100);
            $table->string('location', 100);
            $table->float('rate', 10,2);
            $table->string('genre', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musicbands');
    }
};
