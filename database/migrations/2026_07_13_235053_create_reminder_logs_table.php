<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_schedule_id')->nullable()->constrained('maintenances_schedule')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->string('channel'); // 'whatsapp', 'database'
            $table->string('status'); // 'sent', 'failed'
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_logs');
    }
};
