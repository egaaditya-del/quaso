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
        Schema::create('family_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('families')->onDelete('cascade');
            $table->foreignId('child_id')->constrained('families')->onDelete('cascade');
            $table->enum('relationship_type', ['Ayah', 'Ibu', 'Anak', 'Suami', 'Istri', 'Saudara'])->default('Anak');
            $table->timestamps();
            
            // Ensure no duplicate relationships
            $table->unique(['parent_id', 'child_id', 'relationship_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_relationships');
    }
};
