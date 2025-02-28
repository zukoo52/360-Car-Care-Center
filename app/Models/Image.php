<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'path',
    ];

    protected $filepath = '/storage/images/';

    public function getPathAttribute($value)
    {
        return url($this->filepath . $value);
    }

    protected static function booted()
    {
        parent::boot();
        static::deleting(function ($image) {
            if ($image->getRawOriginal('path') != null) {
                $file_name = $image->getRawOriginal('path');
                Storage::delete('/public/images/' . $file_name);
            }
        });
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}



