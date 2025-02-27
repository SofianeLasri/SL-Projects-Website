<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected function getCoverClass(): string
    {
        return ProjectDraftCover::class;
    }

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

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
