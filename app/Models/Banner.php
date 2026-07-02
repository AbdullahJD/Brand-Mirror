<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title_ar',
        'title_en',
        'title',
        'image',
        'link',
        'status',
        'position'
    ];

    protected $appends = [
        'title',
    ];

    protected $hidden = [
        'title_ar',
        'title_en',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function getTitleAttribute(): ?string
    {
        return $this->translatedValue('title');
    }

    public function setTitleAttribute(?string $value): void
    {
        $this->setTranslatedValue('title', $value);
    }
}
