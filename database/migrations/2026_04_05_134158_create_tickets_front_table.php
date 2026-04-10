<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets_front', function (Blueprint $table) {

            $table->id();

            $table->string('ticket')->unique();

            $table->string('nama');

            $table->string('email');

            $table->string('whatsapp_number')->nullable();

            $table->string('subject');

            $table->string('issuetype');

            $table->string('department');

            $table->string('priority');

            $table->text('description');

            $table->text('attachments')->nullable();

            $table->string('status')->default('Open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets_front');
    }
};
