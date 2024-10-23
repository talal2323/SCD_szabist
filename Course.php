<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses'; // Optional: specify the table name if different from the default

    protected $fillable = [
        'title',
        'credit_hrs',
    ];

    public $timestamps = true; // This enables the created_at and updated_at timestamps
}
