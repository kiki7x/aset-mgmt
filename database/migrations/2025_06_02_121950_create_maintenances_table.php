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
        Schema::create('maintenances_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable();
            $table->string('name'); // Detail pemeliharaan (e.g., 'Ganti Oli Mesin', 'Pembersihan')
            $table->string('frequency')->nullable(); // 'per_3_bulan', 'per_4_bulan', dst '
            $table->date('old_date')->nullable(); // Tanggal manual untuk Korektif
            $table->date('next_date')->nullable();
            $table->string('status')->nullable();
            $table->text('customfields')->nullable();
            $table->timestamps();
        });
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_schedule_id')->nullable(); // Relasi ke maintenance_schedule
            $table->foreignId('asset_id')->nullable(); // Relasi ke asset
            $table->foreignId('pic_id')->nullable(); // Relasi ke Petugas
            $table->foreignId('ticketreply_id')->nullable(); // Relasi ke User yang membuat tiket
            $table->string('name')->nullable();
            $table->string('issuetype')->nullable(); // isian ini jika berdasarkan pada penugasan dan atau korektif
            $table->string('priority')->nullable(); // isian ini jika berdasarkan pada penugasan dan atau korektif
            $table->string('status')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->integer('timespent')->nullable();
            $table->date('period')->nullable(); // Rekam Periode pemeliharaan preventif yang sudah dilakukan
            $table->string('attachment')->nullable();
            $table->text('notes')->nullable(); // Catatan tambahan untuk pemeliharaan
            $table->text('customfields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances_schedule');
        Schema::dropIfExists('maintenances');
    }
};
