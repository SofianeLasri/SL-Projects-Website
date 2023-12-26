<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'ip_adress_id',
        'country_code',
        'url_id',
        'method',
        'user_agent_id',
        'referer_url_id',
        'origin_url_id',
        'content_type_mime_type_id',
        'content_length',
        'status_code',
        'user_id',
    ];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }

    public function referer(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }

    public function userAgent(): BelongsTo
    {
        return $this->belongsTo(UserAgent::class);
    }

    public function contentType(): BelongsTo
    {
        return $this->belongsTo(MimeType::class);
    }

    public function ip(): BelongsTo
    {
        return $this->belongsTo(IpAdress::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
