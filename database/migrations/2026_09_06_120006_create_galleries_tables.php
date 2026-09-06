<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 170)->unique();
            $table->text('description')->nullable();
            $table->string('cover_path', 255)->nullable();
            $table->date('event_date')->nullable();
            $table->timestamps();
        });

        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('photo_path', 255);
            $table->string('caption', 200)->nullable();
            $table->integer('sort_order')->default(0);
        });

        Schema::create('gallery_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('youtube_url', 255);
            $table->string('caption', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_videos');
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('galleries');
    }
};
