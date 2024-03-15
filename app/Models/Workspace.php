<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "remote_id",
        "meta"
    ];


    protected $casts = [
        'meta' => 'array'
    ];

    public function sims(): HasMany
    {
        return $this->HasMany(Sim::class);
    }

    /**
     * Get the oauth access tokens for workspace.
     */
    public function oauth_token(): HasOne
    {
        return $this->hasOne(OauthAccessToken::class);
    }

    /**
     * Get the user for workspace.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
