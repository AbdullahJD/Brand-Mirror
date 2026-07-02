<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name'
    ];

    protected $appends = [
        'name',
    ];

    protected $hidden = [
        'name_ar',
        'name_en',
    ];

    public function getNameAttribute(): ?string
    {
        return $this->translatedValue('name');
    }

    public function setNameAttribute(?string $value): void
    {
        $this->setTranslatedValue('name', $value);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
