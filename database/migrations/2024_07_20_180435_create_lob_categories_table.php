<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('sqlsrv')->create('mst_lob', function (Blueprint $table) {
            $table->id();
            $table->string('lob_name')->unique(); // Name of the LOB category
            $table->timestamps(); // Created at and Updated at
        });

        // Insert predefined LOB categories
        DB::connection('sqlsrv')->table('mst_lob')->insert([
            ['lob_name' => 'KUR'],
            ['lob_name' => 'PEN'],
            ['lob_name' => 'Produktif'],
            ['lob_name' => 'Konsumtif'],
            ['lob_name' => 'Suretyship'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('mst_lob');
    }
};
