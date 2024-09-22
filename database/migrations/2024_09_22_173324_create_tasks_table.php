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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 70)->unique();
            $table->string('description', 250);
            $table->boolean('status')->default(false);
            $table->foreignUuid('assigned_to')->references('id')->on('app_users')->onDelete('cascade');
            $table->foreignUuid('for_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('related_to_project')->constrained('projects')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
