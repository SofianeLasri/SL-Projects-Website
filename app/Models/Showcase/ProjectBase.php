<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;

class ProjectBase extends Model
{
    public static function getContentTranslationKeyPrefix(): string
    {
        return 'project_content_';
    }

    public function getContentTranslationKey(): string
    {
        return $this->getContentTranslationKeyPrefix().$this->id;
    }

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

    protected function getCoverClass()
    {
        return ProjectCover::class;
    }
}
