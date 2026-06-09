<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function getUrlAttribute(): string
    {
        return '/storage/'.$this->path;
    }
}
