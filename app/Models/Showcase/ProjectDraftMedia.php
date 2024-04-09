<?php

namespace App\Models\Showcase;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectDraftMedia extends Model
{
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $fillable = [
        'display_order',
        'type',
        'file_upload_id',
        'link',
        'project_draft_id',
        'name_translation_id',
    ];

    private const NAME_TRANSLATION_KEY_PREFIX = 'project_draft_media_name_';

    const TYPE_FILEUPLOAD = 'fileupload';

    const TYPE_LINK = 'link';

    const TYPE_ENUMS = [
        self::TYPE_FILEUPLOAD,
        self::TYPE_LINK,
    ];

    public function getNameTranslationKey(): string
    {
        return self::NAME_TRANSLATION_KEY_PREFIX.$this->id;
    }

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            if (! self::validateDisplayOrderBeforeSave($model->project_draft_id, $model->display_order)) {
                $model->display_order = self::getNextDisplayOrder($model->project_draft_id);
            }
        });

        self::updating(function ($model) {
            if (! self::validateDisplayOrderBeforeSave($model->project_draft_id, $model->display_order)) {
                $model->display_order = self::getNextDisplayOrder($model->project_draft_id);
            }
        });
    }

    public static function validateDisplayOrderBeforeSave(int $projectId, int $displayOrder): bool
    {
        return ProjectDraftMedia::where('project_draft_id', $projectId)
            ->where('display_order', $displayOrder)
            ->doesntExist();
    }

    public static function getNextDisplayOrder(int $projectId): int
    {
        $maxDisplayOrder = ProjectDraftMedia::where('project_draft_id', $projectId)
            ->max('display_order');

        return $maxDisplayOrder + 1;
    }

    public function scopeForProjectDraft(Builder $query, ProjectDraft $project): void
    {
        $query->where('project_draft_id', $project->id);
    }

    public function setNameTranslation(string $name, string $locale): void
    {
        $translation = Translation::updateOrCreateTranslation(
            $this->getNameTranslationKey(),
            $locale,
            $name
        );

        $this->name_translation_id = $translation->translationKey->id;
    }
}
