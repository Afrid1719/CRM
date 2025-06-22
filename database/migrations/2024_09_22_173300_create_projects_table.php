<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
            $table->string('title', 120);
            $table->string('description', 250);
            $table->timestamp('deadline')->useCurrent();
            $table->foreignUuid('assigned_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('assigned_client')->references('id')->on('clients')->onDelete('cascade');
            $table->enum('status', ['Open', 'In progress', 'Completed'])->default('Open');
            $table->timestamps();
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
