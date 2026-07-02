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
        Schema::create('licensecategories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 7);
            $table->timestamps();
        });
        Schema::create('licenses_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('license_id');
            $table->unsignedBigInteger('asset_id');
            $table->timestamps();
        });
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained(
                table: 'labels',
                indexName: 'licenses_labels_id'
            );
            $table->foreignId('category_id')->constrained(
                table: 'licensecategories',
                indexName: 'licenses_category_id'
            );
            $table->foreignId('supplier_id')->constrained(
                table: 'suppliers',
                indexName: 'licenses_supplier_id'
            );
            $table->string('seats', 5);
            $table->string('tag', 255)->unique();
            $table->string('name', 255);
            $table->text('serial');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('licenses_assets');
        Schema::dropIfExists('licensecategories');
    }
};
