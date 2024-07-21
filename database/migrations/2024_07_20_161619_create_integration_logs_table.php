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
        Schema::connection('sqlsrv')->create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('process_date');
            $table->integer('data_count');
            $table->string('status');
            $table->timestamp('created_at')->nullable(); // Only created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv')->dropIfExists('integration_logs');
    }
};
