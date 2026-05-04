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
        Schema::create('assetclassifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });
        Schema::create('assetcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('color', 7)->nullable();
            $table->foreignId('classification_id')->constrained('assetclassifications')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_id')->constrained(
                table: 'assetclassifications',
                indexName: 'assets_classification_id'
            )->onDelete('cascade');
            $table->foreignId('category_id')->constrained(
                table: 'assetcategories',
                indexName: 'assets_category_id'
            );
            $table->foreignId('admin_id')->constrained(
                table: 'users',
                indexName: 'assets_admin_id'
            );
            $table->foreignId('client_id')->constrained(
                table: 'clients',
                indexName: 'assets_client_id'
            );
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'assets_user_id'
            );
            $table->foreignId('manufacturer_id')->constrained(
                table: 'manufacturers',
                indexName: 'assets_manufacturer_id'
            );
            $table->foreignId('model_id')->constrained(
                table: 'models',
                indexName: 'assets_model_id'
            );
            $table->foreignId('supplier_id')->constrained(
                table: 'suppliers',
                indexName: 'assets_supplier_id'
            );
            $table->foreignId('status_id')->constrained(
                table: 'labels',
                indexName: 'assets_status_id'
            );
            $table->foreignId('location_id')->constrained(
                table: 'locations',
                indexName: 'assets_location_id'
            );
            $table->date('purchase_date');
            $table->unsignedBigInteger('warranty_months');
            $table->string('tag', 255)->unique();
            $table->string('name', 255);
            $table->string('serial', 255)->unique();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->text('customfields')->nullable();
            $table->text('qrvalue')->nullable();
            $table->timestamps(); // adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assetclassifications');
        Schema::dropIfExists('assetcategories');
        Schema::dropIfExists('assets');
    }
};
