<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchPhone extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'type',
        'branch_id'
    ];

    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
