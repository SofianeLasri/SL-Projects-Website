<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

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
}
