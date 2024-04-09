<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends ProjectBase
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_ARCHIVED = 'archived';

    public const STATUS_ENUMS = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_ARCHIVED,
    ];

    public const RELEASE_STATUS_RUNNING = 'running';

    public const RELEASE_STATUS_FINISHED = 'finished';

    public const RELEASE_STATUS_CANCELLED = 'cancelled';

    public const RELEASE_STATUS_ENUMS = [
        self::RELEASE_STATUS_RUNNING,
        self::RELEASE_STATUS_FINISHED,
        self::RELEASE_STATUS_CANCELLED,
    ];

    protected $connection = 'showcase';

    protected $fillable = [
        'name',
        'status',
        'slug',
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

    public static function createEmptyProjectForDraft(string $slug, string $name): Project
    {
        return Project::create([
            'slug' => $slug,
            'name' => $name,
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function draft(): HasMany
    {
        return $this->hasMany(ProjectDraft::class);
    }

    public function medias(): HasMany
    {
        return $this->hasMany(ProjectMedia::class);
    }
}
