<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimsPerLob extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv'; // Specify the database connection

    protected $table = 'claims_per_lob'; // Specify the table name

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'lob',
        'claim_cause',
        'claim_qty',
        'period',
        'claim_value',
    ];

    // Define the timestamps field
    public $timestamps = true;
}
