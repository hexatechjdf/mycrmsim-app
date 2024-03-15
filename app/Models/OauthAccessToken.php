<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class OauthAccessToken extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'access_token',
        'refresh_token',
        'token_type',
        'scope',
        'workspace_id',
        'meta',
        'installed_by'
    ];

    /**
     * Get the workspaces for the oauth access token.
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function refresh(): bool
    {
        $response = Http::asForm()->post("https://services.leadconnectorhq.com/oauth/token", [
            "client_id" => config("services.ghl.key"),
            "client_secret" => config("services.ghl.secret"),
            "grant_type" => "refresh_token",
            "refresh_token" => $this->refresh_token
        ]);

        if($response->ok())
        {
            $body = $response->object();
            $this->access_token = $body->access_token;
            $this->refresh_token = $body->refresh_token;
            $this->token_type = $body->token_type;
            $this->scope = $body->scope;
            $this->save();
        }


        return $response->ok();
    }
}
