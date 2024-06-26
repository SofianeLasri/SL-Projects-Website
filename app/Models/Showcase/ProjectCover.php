<?php

namespace App\Models\Showcase;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCover extends Model
{
    use HasFactory;

    protected $connection = 'showcase';

    public $timestamps = false;

    protected $fillable = [
        'file_upload_id',
        'ratio',
    ];

    const SQUARE_RATIO = 'square';

    const POSTER_RATIO = 'poster';

    const FULLWIDE_RATIO = 'fullwide';

    const RATIO_ENUMS = [
        self::SQUARE_RATIO,
        self::POSTER_RATIO,
        self::FULLWIDE_RATIO,
    ];

    public function scopeForProject($query, Project $project)
    {
        return $query->where('project_id', $project->id);
    }

    public function fileUpload()
    {
        return $this->belongsTo(FileUpload::class, 'file_upload_id', 'id');
    }
}
