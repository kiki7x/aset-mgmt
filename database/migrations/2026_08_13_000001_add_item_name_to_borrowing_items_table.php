<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowing_items', function (Blueprint $table) {
            $table->foreignId('asset_id')->nullable()->change();
            $table->string('item_name')->nullable()->after('asset_id');
        });
    }

    public function down(): void
    {
        Schema::table('borrowing_items', function (Blueprint $table) {
            $table->dropColumn('item_name');
        });
    }
};
