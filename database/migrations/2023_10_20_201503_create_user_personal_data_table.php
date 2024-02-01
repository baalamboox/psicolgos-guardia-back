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
            $table->unsignedTinyInteger('age')->nullable();
            $table->text('gender')->nullable();
            $table->string('address', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->text('professional_title')->nullable();
            $table->string('specialty', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('professional_license', 10)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('whatsapp', 10)->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('sex', 10)->nullable();
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
