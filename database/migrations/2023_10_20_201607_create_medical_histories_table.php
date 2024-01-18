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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('treatment_plan')->nullable();
            $table->date('admission_date');
            $table->text('clinical_evaluation')->nullable();
            $table->text('current_problematic_description')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('psychological_history')->nullable();
            $table->text('medication')->nullable();
            $table->text('provisional_diagnosis')->nullable();
            $table->text('traumatic_experiences')->nullable();
            $table->text('psychosocial_history')->nullable();
            $table->text('substance_consumption')->nullable();
            $table->text('ailments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
