<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'type',
        'image_url',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translationFor(Language $language): ?PageTranslation
    {
        return $this->translations->firstWhere('language_id', $language->id);
    }
}
