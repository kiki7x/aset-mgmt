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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // id column (AUTO_INCREMENT and PRIMARY KEY)
            $table->unsignedInteger('ticket'); // ticket column (integer)
            $table->unsignedInteger('department_id'); // departmentid column (integer)
            $table->unsignedInteger('client_id'); // clientid column (integer)
            $table->unsignedInteger('user_id'); // userid column (integer)
            $table->unsignedInteger('admin_id'); // adminid column (integer)
            $table->unsignedInteger('asset_id'); // assetid column (integer)
            $table->unsignedInteger('project_id'); // projectid column (integer)
            $table->string('email', 128); // email column (VARCHAR 128)
            $table->string('subject', 500); // subject column (VARCHAR 500)
            $table->string('status', 50); // status column (VARCHAR 50)
            $table->string('priority', 50); // priority column (VARCHAR 50)
            $table->longText('notes'); // notes column (LONGTEXT)
            $table->string('ccs', 255); // ccs column (VARCHAR 255)
            $table->unsignedInteger('timespent'); // timespent column (integer)
            $table->timestamps(); // created_at and updated_at columns
        });
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('tickets_departments');
        Schema::dropIfExists('tickets_predefine_reply');
        Schema::dropIfExists('tickets_replies');
        Schema::dropIfExists('tickets_rules');
    }
};
