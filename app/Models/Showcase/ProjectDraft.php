<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDraft extends ProjectBase
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

    public static function getContentTranslationKeyPrefix(): string
    {
        return 'project_draft_content_';
    }

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

    public function medias(): HasMany
    {
        return $this->hasMany(ProjectDraftMedia::class);
    }

    public function covers(): HasMany
    {
        return $this->hasMany(ProjectDraftCover::class);
    }
}
