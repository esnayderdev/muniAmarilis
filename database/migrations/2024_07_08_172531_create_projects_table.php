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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name_project', 255);
            $table->text('description');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('status', 55);
            $table->unsignedBigInteger('encargado_id');
            $table->timestamps();

            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
