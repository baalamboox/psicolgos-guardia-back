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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('psychologist_user_id');
            $table->unsignedBigInteger('patient_user_id');
            $table->string('reason_inquiry', 255);
            $table->string('note', 255);
            $table->time('preferred_time');
            $table->date('preferred_date');
            $table->string('way_pay', 64);
            $table->string('state', 32);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
