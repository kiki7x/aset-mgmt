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
        Schema::create('tickets_departments', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->string('name', 255); // name column (VARCHAR 255)
            $table->text('email'); // email column (TEXT)
            $table->timestamps(); // created_at and updated_at columns
        });
        Schema::create('tickets_predefine_reply', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->string('name', 255); // name column (VARCHAR 255)
            $table->longText('content'); // content column (LONGTEXT)
            $table->timestamps(); // created_at and updated_at columns
        });
        Schema::create('tickets_replies', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->unsignedInteger('ticket_id'); // ticketid column (integer)
            $table->unsignedInteger('people_id'); // peopleid column (integer)
            $table->longText('message'); // message column (LONGTEXT)
            $table->timestamps(); // created_at and updated_at columns
        });
        Schema::create('tickets_rules', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->unsignedInteger('ticket_id'); // ticketid column (integer)
            $table->integer('executed'); // executed column (integer)
            $table->string('name', 255); // name column (VARCHAR 255)
            $table->string('cond_status', 255); // cond_status column (VARCHAR 255)
            $table->string('cond_priority', 255); // cond_priority column (VARCHAR 255)
            $table->string('cond_timeelapsed', 20); // cond_timeelapsed column (VARCHAR 20)
            $table->dateTime('cond_datetime'); // cond_datetime column (DATETIME)
            $table->string('act_status', 255); // act_status column (VARCHAR 255)
            $table->string('act_priority', 255); // act_priority column (VARCHAR 255)
            $table->unsignedInteger('act_assignto'); // act_assignto column (integer)
            $table->unsignedInteger('act_notifyadmins'); // act_notifyadmins column (integer)
            $table->unsignedInteger('act_addreply'); // act_addreply column (integer)
            $table->text('reply'); // reply column (TEXT)
            $table->timestamps(); // created_at and updated_at columns
        });
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->string('ticket', 255)->unique(); // ticket column (VARCHAR 255, UNIQUE)
            $table->string('nama', 255); // nama column (VARCHAR 255)
            $table->string('email', 255); // email column (VARCHAR 255)
            $table->string('whatsapp_number', 20)->nullable(); // whatsapp_number column (VARCHAR 20, nullable)
            $table->string('subject', 255); // subject column (VARCHAR 255)
            $table->string('issuetype', 255); // issuetype column (VARCHAR 255)
            $table->string('department', 255); // department column (VARCHAR 255)
            $table->string('priority', 50); // priority column (VARCHAR 50)
            $table->text('description'); // description column (TEXT)
            $table->text('attachments')->nullable(); // attachments column (TEXT, nullable)
            $table->string('status', 50)->default('Open'); // status column (VARCHAR 50, default 'Open')
            $table->text('reason')->nullable();
            $table->longText('notes'); // notes column (LONGTEXT)
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_departments');
        Schema::dropIfExists('tickets_predefine_reply');
        Schema::dropIfExists('tickets_replies');
        Schema::dropIfExists('tickets_rules');
        Schema::dropIfExists('tickets');
    }
};
