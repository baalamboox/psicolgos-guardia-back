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
        Schema::create('user_personal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('names', 32);
            $table->string('first_surname', 16);
            $table->string('second_surname', 16);
            $table->unsignedTinyInteger('age');
            $table->text('gender');
            $table->string('address', 255);
            $table->date('birthday');
            $table->string('specialty', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('professional_license', 10)->nullable();
            $table->string('phone', 10);
            $table->string('curp', 18);
            $table->string('sex', 10);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_personal_data');
    }
};