<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    protected function translatedValue(string $attribute): mixed
    {
        $locale = app()->getLocale() === 'ar' ? 'ar' : 'en';
        $fallbackLocale = $locale === 'ar' ? 'en' : 'ar';

        return $this->attributes["{$attribute}_{$locale}"]
            ?? $this->attributes["{$attribute}_{$fallbackLocale}"]
            ?? null;
    }

    protected function setTranslatedValue(string $attribute, mixed $value): void
    {
        $this->attributes["{$attribute}_ar"] = $value;
        $this->attributes["{$attribute}_en"] = $value;
    }

    protected function translatedJsonValue(string $attribute): array
    {
        $value = $this->translatedValue($attribute);

        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || $value === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    protected function setTranslatedJsonValue(string $attribute, mixed $value): void
    {
        $encodedValue = is_null($value)
            ? null
            : json_encode($value, JSON_UNESCAPED_UNICODE);

        $this->attributes["{$attribute}_ar"] = $encodedValue;
        $this->attributes["{$attribute}_en"] = $encodedValue;
    }
}
