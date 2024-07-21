<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationClaim extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_db2'; // Specify the database connection

    protected $table = 'integration_claims'; // Specify the table name

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'claim_id',
        'lob',
        'claim_cause',
        'claim_qty',
        'period',
        'claim_value',
    ];

    // Define the timestamps field
    public $timestamps = true;
}
