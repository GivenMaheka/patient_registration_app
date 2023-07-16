<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('patients');
        Schema::create('patients', function (Blueprint $table) {
            $table->string('patient_id')->primary();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->date('birth_date')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->enum('gender',['male','female'])->nullable(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
