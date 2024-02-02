<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    protected $fillable = [
        'display_order',
        'file_upload_id',
        'name_translation_id',
        'description_translation_id',
    ];
}
