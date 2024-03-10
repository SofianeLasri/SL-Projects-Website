<?php

namespace App\Models\Showcase;

use App\Models\ProjectDraftMedia;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDraft extends Model
{
    protected $connection = 'showcase';

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'content_translation_id',
        'release_status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    private const CONTENT_TRANSLATION_KEY_PREFIX = 'project_draft_content_';

    public static function findOrCreateDraft(int $projectId, string $name): ProjectDraft
    {
        $draft = ProjectDraft::where('project_id', $projectId)->first();
        if (! $draft) {
            $draft = new ProjectDraft();
            $draft->project_id = $projectId;
            $draft->name = $name;
            $draft->save();
        }

        return $draft;
    }

    public function getContentTranslationKey(): string
    {
        return self::CONTENT_TRANSLATION_KEY_PREFIX.$this->id;
    }

    /**
     * Get the content translation of the project.
     *
     * @param  string|null  $locale  The locale of the translation. If null, the app locale will be used.
     * @return string The content translation of the project. If the translation does not exist, an empty string will be returned.
     */
    public function getTranslationContent(?string $locale = null): string
    {
        $locale = $locale ?? config('app.locale');
        $translation = Translation::getTranslation($this->getContentTranslationKey(), $locale);

        return $translation ? $translation->message : '';
    }

    public function medias(): HasMany
    {
        return $this->hasMany(ProjectDraftMedia::class);
    }
}
