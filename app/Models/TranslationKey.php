<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationKey extends Model
{
    public $timestamps = false;

    protected $table = 'translations_indices';

    protected $fillable = [
        'key',
    ];
}
