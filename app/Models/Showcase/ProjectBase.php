<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectBase extends Model
{
    protected function getCoverClass(): string
    {
        return ProjectCover::class;
    }

    public static function getContentTranslationKeyPrefix(): string
    {
        return 'project_content_';
    }

    public function getContentTranslationKey(): string
    {
        return $this->getContentTranslationKeyPrefix().$this->id;
    }

    /**
     * Set the content translation of the project.
     *
     * @param  string  $content  The content translation of the project.
     * @param  string  $locale  The locale of the translation.
     */
    public function setTranslationContent(string $content, string $locale): void
    {
        $translation = Translation::updateOrCreateTranslation($this->getContentTranslationKey(), $locale, $content);
        $this->content_translation_id = $translation->translationKey->id;

        $this->save();
    }

    /**
     * Get the content translation of the project.
     *
     * @param  string  $locale  The locale of the translation. If null, the app locale will be used.
     * @return string The content translation of the project. If the translation does not exist, an empty string will be returned.
     */
    public function getTranslationContent(string $locale): string
    {
        $translation = Translation::getTranslation($this->getContentTranslationKey(), $locale);

        return $translation ? $translation->message : '';
    }

    public function medias(): HasMany
    {
        return $this->hasMany(ProjectDraftMedia::class);
    }

    public function covers(): HasMany
    {
        return $this->hasMany($this->getCoverClass());
    }

    public function square_cover(): HasOne
    {
        return $this->hasOne($this->getCoverClass())->where('ratio', ProjectCover::SQUARE_RATIO);
    }

    public function poster_cover(): HasOne
    {
        return $this->hasOne($this->getCoverClass())->where('ratio', ProjectCover::POSTER_RATIO);
    }

    public function fullwide_cover(): HasOne
    {
        return $this->hasOne($this->getCoverClass())->where('ratio', ProjectCover::FULLWIDE_RATIO);
    }
}
