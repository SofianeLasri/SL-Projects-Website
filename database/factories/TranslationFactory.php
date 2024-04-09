<?php

namespace Database\Factories;

use App\Models\Translation;
use App\Models\TranslationKey;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition(): array
    {
        $translationKey = TranslationKey::factory()->create();
        return [
            'translation_key_id' => $translationKey->id,
            'country_code' => $this->faker->randomElement(Translation::COUNTRY_CODES_ENUM),
            'message' => $this->faker->word(),
        ];
    }

    public function withKey(string $key): TranslationFactory
    {
        return $this->afterCreating(function (Translation $translation) use ($key) {
            $translation->translationKey()->associate(TranslationKey::factory()->create(['key' => $key]));
            $translation->save();
        });
    }
}
