<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnprocessableFileUpload extends Model
{
    protected $connection = 'main';
    const TASK_CONVERSION = 'conversion';
    protected $fillable = [
        'file_upload_id',
        'reason',
        'task',
    ];
}
