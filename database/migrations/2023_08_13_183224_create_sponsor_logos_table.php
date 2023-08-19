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
        Schema::create('sponsor_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->integer('transportation')->default(0);
            $table->string('event')->nullable();
            $table->string('event2')->nullable();
            $table->text('description')->nullable();
            $table->integer('issponsornow')->default(0);
            $table->integer('orderby')->default(0);
            $table->integer('ticketid')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_logos');
    }
};
