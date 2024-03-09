<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $connection = 'main';

    public $timestamps = false;

    protected $fillable = [
        'index',
        'country_code',
        'message',
    ];

    public static function updateOrCreateTranslation(string $index, string $countryCode, string $message): Translation
    {
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
}
