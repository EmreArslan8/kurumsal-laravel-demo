<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationEntry extends Model
{
    protected $fillable = [
        'group',
        'translation_key',
        'language_id',
        'value',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
