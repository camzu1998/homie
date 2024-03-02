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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->nullableMorphs('entriesable');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_succeed')->nullable();
            $table->boolean('is_generated')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
