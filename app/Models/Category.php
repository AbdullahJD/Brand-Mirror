<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name',
        'description_ar',
        'description_en',
        'description',
        'parent_id',
        'status',
        'image',
    ];

    protected $appends = [
        'name',
        'description',
    ];

    protected $hidden = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
    ];

    public function getNameAttribute(): ?string
    {
        return $this->translatedValue('name');
    }

    public function setNameAttribute(?string $value): void
    {
        $this->setTranslatedValue('name', $value);
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translatedValue('description');
    }

    public function setDescriptionAttribute(?string $value): void
    {
        $this->setTranslatedValue('description', $value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('status', 1);
    }

    public function activeProducts()
    {
    return $this->hasMany(Product::class)
        ->where('status', 1);
    }
}
