<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('vital_details');
        Schema::create('vital_details', function (Blueprint $table) {
            $table->bigInteger("id")->autoIncrement();
            $table->integer("visit_id")->unique()->nullable(false);
            $table->string("patient_id")->nullable(false);
            $table->dateTime("date")->nullable(false);
            $table->enum("health", ["good", "bad"])->nullable(false);
            $table->string("onDiet")->nullable(true);
            $table->string("onDrugs")->nullable(true);
            $table->longText("comments")->nullable(false);

            $table->foreign("patient_id")
                ->references("patient_id")->on('patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign("visit_id")
                ->references("id")->on('visits')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_details');
    }
};
