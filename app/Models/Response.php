<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Response
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $method
 * @property int $http_status
 * @property string|null $slug
 * @property string|null $body
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Request> $requests
 * @property-read int|null $requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|Response newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Response newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Response query()
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereHttpStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereUpdatedAt($value)
 * @property array|null $headers
 * @property-read string $url
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereHeaders($value)
 * @mixin \Eloquent
 */
class Response extends Model
{
    protected $fillable = [
        'method',
        'http_status',
        'slug',
        'body',
        'headers',
    ];

    protected $casts = [
        'headers' => 'array',
    ];

    protected $appends = [
        'url',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function getUrlAttribute(): string
    {
        return route('catch', [$this->slug]);
    }
}
