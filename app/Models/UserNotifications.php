<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'has_read'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
