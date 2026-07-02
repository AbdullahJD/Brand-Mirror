<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'attribute_id',
        'value_ar',
        'value_en',
        'value'
    ];

    protected $appends = [
        'value',
    ];

    protected $hidden = [
        'value_ar',
        'value_en',
    ];

    public function getValueAttribute(): ?string
    {
        return $this->translatedValue('value');
    }

    public function setValueAttribute(?string $value): void
    {
        $this->setTranslatedValue('value', $value);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_attribute_values'
        );
    }
}
