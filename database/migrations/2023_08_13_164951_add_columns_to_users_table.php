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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->boolean('is_profile_setup')->default(0);
            $table->boolean('is_favourite')->default(0);
            $table->text('about_me')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('skype_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('token')->nullable();
            $table->text('fb_token')->nullable();
            $table->text('google_token')->nullable();
            $table->text('social_token')->nullable();
            $table->tinyInteger('is_verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('is_profile_setup');
            $table->dropColumn('whatsapp_link');
            $table->dropColumn('about_me');
            $table->dropColumn('skype_link');
            $table->dropColumn('instagram_link');
            $table->dropColumn('telegram_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('facebook_link');
            $table->dropColumn('linkedin_link');
            $table->dropColumn('profile_image');
            $table->dropColumn('token');
            $table->dropColumn('is_verified');
        });
    }
};
