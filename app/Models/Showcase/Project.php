<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
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
}
