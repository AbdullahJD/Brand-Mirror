<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'name',
        'description_ar',
        'description_en',
        'description',
        'price',
        'discount_price',
        'stock',
        'main_image',
        'is_featured',
        'status',
        'additional_information_ar',
        'additional_information_en',
        'additional_information',
    ];

    protected $casts = [
        'additional_information_ar' => 'array',
        'additional_information_en' => 'array',
    ];

    protected $appends = [
        'name',
        'description',
        'additional_information',
    ];

    protected $hidden = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'additional_information_ar',
        'additional_information_en',
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

    public function getAdditionalInformationAttribute(): array
    {
        return $this->translatedJsonValue('additional_information');
    }

    public function setAdditionalInformationAttribute(mixed $value): void
    {
        $this->setTranslatedJsonValue('additional_information', $value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
