<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv'; // Specify the database connection

    protected $table = 'integration_logs'; // Specify the table name

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'process_date',
        'data_count',
        'status',
        'created_at',
    ];

    // Disable automatic timestamps
    public $timestamps = false;
}
