<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
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

    private const CONTENT_TRANSLATION_KEY_PREFIX = 'project_content_';

    public static function createEmptyProjectForDraft(string $slug, string $name): Project
    {
        return Project::create([
            'slug' => $slug,
            'name' => $name,
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function draft(): HasOne
    {
        return $this->hasOne(ProjectDraft::class);
    }

    public function square_cover(): HasOne
    {
        return $this->hasOne(ProjectCover::class, 'project_id', 'id')->where('ratio', ProjectCover::SQUARE_RATIO);
    }

    public function poster_cover(): HasOne
    {
        return $this->hasOne(ProjectCover::class, 'project_id', 'id')->where('ratio', ProjectCover::POSTER_RATIO);
    }

    public function fullwide_cover(): HasOne
    {
        return $this->hasOne(ProjectCover::class, 'project_id', 'id')->where('ratio', ProjectCover::FULLWIDE_RATIO);
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
    public function getTranslationContent(string $locale): string
    {
        $translation = Translation::getTranslation($this->getContentTranslationKey(), $locale);

        return $translation ? $translation->message : '';
    }

    public function medias(): HasMany
    {
        return $this->hasMany(ProjectMedia::class);
    }
}
