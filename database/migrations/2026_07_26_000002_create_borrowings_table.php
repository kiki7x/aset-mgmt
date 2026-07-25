<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ruangan', 'barang']);
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->foreignId('asset_id')->nullable()->constrained('assets');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('borrower_name', 255);
            $table->string('borrower_nip', 64)->nullable();
            $table->string('borrower_unit', 255)->nullable();
            $table->datetime('borrow_start');
            $table->datetime('borrow_end');
            $table->datetime('return_date')->nullable();
            $table->text('purpose');
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->string('borrower_photo')->nullable();
            $table->string('return_photo')->nullable();
            $table->string('original_asset_status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
