<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('visits');
        Schema::create('visits', function (Blueprint $table) {
            $table->integer("id")->primary();
            $table->string("patient_id")->nullable(false);
            $table->dateTime("date")->nullable(false);
            $table->string("height")->nullable(false);
            $table->string("weight")->nullable(false);
            $table->double("bmi")->nullable(false);

            $table->foreign("patient_id")
            ->references("patient_id")->on('patients')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
