<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('patients_registered_by');
        Schema::create('patients_registered_by', function (Blueprint $table) {
            $table->bigInteger("vital_id")->unique();
            $table->string("registeredBy");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_registered_by');
    }
};
