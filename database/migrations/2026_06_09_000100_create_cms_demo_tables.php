<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 8)->unique();
            $table->string('direction', 3)->default('ltr');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('type')->default('content');
            $table->string('image_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('menu_title')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['page_id', 'language_id']);
        });

        Schema::create('translation_entries', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('site');
            $table->string('translation_key');
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['translation_key', 'language_id']);
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 8)->default('tr');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('translation_entries');
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('languages');
    }
};
