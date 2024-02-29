<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Request
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $response_id
 * @property array|null $headers
 * @property string|null $content
 * @property-read \App\Models\Response $response
 * @method static \Illuminate\Database\Eloquent\Builder|Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request query()
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Request extends Model
{
    protected $fillable = [
        'response_id',
        'headers',
        'content',
    ];

    protected $casts = [
        'headers' => 'array',
    ];

    protected $appends = [
        'url',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }

    public function getUrlAttribute(): string
    {
        return $this->response->url;
    }
}
