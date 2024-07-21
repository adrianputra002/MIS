<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstLob extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv'; // Specify the database connection
    // Define the table associated with the model
    protected $table = 'mst_lob';

    // If you want to use timestamps, keep this as true
    public $timestamps = false;

    // Define the fillable fields if you want to use mass assignment
    protected $fillable = [
        'name',  // Assuming there's a 'name' column for LOB names
];
}
