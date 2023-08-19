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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('activ_status')->default(0);
            $table->integer('ticketholder')->nullable();
            $table->string('activ_key')->nullable();
            $table->integer('role')->nullable();
            $table->integer('rolul')->nullable();
            $table->integer('revshare')->nullable();
            $table->string('pps')->nullable();
            $table->integer('sponsor')->nullable();
            $table->string('utilizator')->nullable();
            $table->string('slack')->nullable();
            $table->text('avatar')->nullable();
            $table->string('passwordreset')->nullable();
            $table->integer('referredby')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
