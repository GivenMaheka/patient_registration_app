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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->enum('gender',['male','female']);
            $table->longText('password');
            $table->boolean('status');
            $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
