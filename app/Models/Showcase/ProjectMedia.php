<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    use HasFactory;
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $fillable = [
        'display_order',
        'type',
        'file_upload_id',
        'link',
        'project_id',
    ];

    const TYPE_FILEUPLOAD = 'fileupload';
    const TYPE_LINK = 'link';
    const TYPE_ENUMS = [
        self::TYPE_FILEUPLOAD,
        self::TYPE_LINK,
    ];
}
