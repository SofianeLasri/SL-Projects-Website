<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationKey extends Model
{
    protected $connection = 'main';

    public $timestamps = false;

    protected $table = 'translations_indices';

    protected $fillable = [
        'key',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'id', 'translation_key_id');
    }
}
