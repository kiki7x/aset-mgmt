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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->unsignedInteger('client_id'); // clientid column (integer)
            $table->string('name', 255)->unique(); // name column (VARCHAR 255)
            $table->timestamps(); // created_at and updated_at columns
        });
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->unsignedInteger('building_id'); // buildingid column (integer)
            $table->string('name', 255); // name column (VARCHAR 255)
            $table->string('lantai', 100); // lantai column (VARCHAR 100, nullable)
            $table->timestamps(); // created_at and updated_at columns
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('locations');
    }
};
