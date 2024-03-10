<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Translation extends Model
{
    protected $connection = 'main';

    public $timestamps = false;

    protected $fillable = [
        'index',
        'country_code',
        'message',
    ];

    /**
     * Update or create a translation into the database for the given index and country code.
     *
     * @param  string  $index  The index of the translation. Ex: 'welcome_message'.
     * @param  string  $countryCode  The country code of the translation. Ex: 'en'.
     * @param  string  $message  The message of the translation.
     * @return Translation The translation model.
     */
    public static function updateOrCreateTranslation(string $index, string $countryCode, string $message): Translation
    {
        $countryCode = Str::upper($countryCode);
        $translationIndex = TranslationKey::firstOrCreate(['key' => $index]);
        $translationIndex->save();

        $translation = $translationIndex->translations()->where('country_code', $countryCode)->first();

        if (! $translation) {
            $translation = new Translation();
            $translation->translation_key_id = $translationIndex->id;
            $translation->country_code = $countryCode;
        }

        $translation->message = $message;
        $translation->save();

        return $translation;
    }

    /**
     * Get the translation for the given index and country code. If the translation does not exist, it will return null.
     *
     * @param  string  $index  The index of the translation. Ex: 'welcome_message'.
     * @param  string  $countryCode  The country code of the translation. Ex: 'en'.
     * @return Translation|null The translation model.
     */
    public static function getTranslation(string $index, string $countryCode): ?Translation
    {
        $countryCode = Str::upper($countryCode);
        $translationIndex = TranslationKey::where('key', $index)->first();

        return $translationIndex?->translations()->where('country_code', $countryCode)->first();
    }

    /**
     * Get the message of the translation for the given index and country code. If the translation does not exist, it will return the index (same behavior as Laravel).
     *
     * @param  string  $index  The index of the translation. Ex: 'welcome_message'.
     * @param  string  $countryCode  The country code of the translation. Ex: 'en'.
     * @return string The message of the translation.
     */
    public static function getTranslationMessage(string $index, string $countryCode): string
    {
        $translation = self::getTranslation($index, $countryCode);

        return $translation ? $translation->message : $index;
    }
}
