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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 32)->unique()->index();
            $table->string('name', 120);
            $table->boolean('is_anonymous')->default(false);
            $table->string('category', 50)->index(); // kritik_saran, fasilitas, akademik, bullying, pelayanan, lainnya
            $table->string('role', 50)->index();     // siswa, wali_murid, guru_staf, alumni, masyarakat
            $table->string('email', 120)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('title', 255);
            $table->text('content');
            $table->string('attachment', 255)->nullable();
            $table->string('status', 30)->default('pending')->index(); // pending, diproses, selesai, ditolak
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
