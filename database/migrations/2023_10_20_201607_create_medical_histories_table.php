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
            $table->text('treatment_plan');
            $table->date('admission_date');
            $table->text('clinical_evaluation');
            $table->text('current_problematic_description');
            $table->text('medical_history');
            $table->text('psychological_history');
            $table->text('medication');
            $table->text('provisional_diagnosis');
            $table->text('traumatic_experiences');
            $table->text('psychosocial_history');
            $table->text('substance_consumption');
            $table->text('ailments');
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
