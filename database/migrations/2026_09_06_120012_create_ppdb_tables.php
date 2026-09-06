<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_open')->default(false);
            $table->string('academic_year', 20);
            $table->text('intro_text')->nullable();
            $table->string('registration_url', 255)->nullable();
            $table->text('requirements')->nullable();
            $table->timestamps();
        });

        Schema::create('ppdb_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_setting_id')->constrained('ppdb_settings')->cascadeOnDelete();
            $table->string('stage_name', 150);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('sort_order')->default(0);
        });

        Schema::create('ppdb_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_setting_id')->constrained('ppdb_settings')->cascadeOnDelete();
            $table->string('question', 255);
            $table->text('answer');
            $table->integer('sort_order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_faqs');
        Schema::dropIfExists('ppdb_timelines');
        Schema::dropIfExists('ppdb_settings');
    }
};
