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
        Schema::connection('sqlsrv_db2')->create('integration_claims', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('claim_id'); // Cause of claim
            $table->string('lob'); // Line of Business
            $table->string('claim_cause'); // Cause of claim
            $table->bigInteger('claim_qty'); // Cause of claim
            $table->date('period'); // Period of the claim
            $table->decimal('claim_value', 30, 2); // Claim value
            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_db2')->dropIfExists('integration_claims');
    }
};
