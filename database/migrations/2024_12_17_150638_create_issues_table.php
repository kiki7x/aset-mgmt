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
        Schema::create('issues', function (Blueprint $table) {
            $table->id(); // Primary Key, AUTO_INCREMENT
            $table->foreignId('client_id')->constrained(
                table: 'users',
                indexName: 'issues_client_id'
            );
            $table->foreignId('asset_id')->nullable();
            $table->foreignId('ticketreply_id')->nullable()->constrained(
                table: 'tickets',
                indexName: 'issues_ticketreply_id'
            );
            $table->foreignId('project_id')->nullable()->constrained(
                table: 'projects',
                indexName: 'issues_project_id'
            );
            $table->foreignId('admin_id')->nullable()->constrained(
                table: 'users',
                indexName: 'issues_admin_id'
            );
            $table->foreignId('milestone_id')->nullable()->constrained(
                table: 'milestones',
                indexName: 'issues_milestone_id'
            );
            $table->string('issuetype', 15);
            $table->string('priority', 60);
            $table->string('status', 60);
            $table->string('name', 255);
            $table->longText('description')->nullable();
            $table->date('duedate', 20);
            $table->unsignedInteger('timespent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
