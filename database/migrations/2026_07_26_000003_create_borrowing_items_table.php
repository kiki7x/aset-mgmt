<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained('assets');
            $table->string('original_asset_status')->nullable();
            $table->timestamps();
        });

        // Migrasi data peminjaman barang lama ke borrowing_items
        DB::table('borrowing_items')->insertUsing(
            ['borrowing_id', 'asset_id', 'original_asset_status', 'created_at', 'updated_at'],
            DB::table('borrowings')
                ->where('type', 'barang')
                ->whereNotNull('asset_id')
                ->select('id', 'asset_id', 'original_asset_status', 'created_at', 'updated_at')
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_items');
    }
};
