<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'manufacturing',
        'manufacturer',
        'cost_per_one',
        'price_per_one',
        'total_quantity',
    ];

}
