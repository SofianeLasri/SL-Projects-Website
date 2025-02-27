<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationKey extends Model
{
    use HasFactory;
    protected $connection = 'main';

    public $timestamps = false;

    protected $table = 'translations_indices';

    protected $fillable = [
        'key',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'translation_key_id', 'id');
    }
}
