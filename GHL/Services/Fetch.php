<?php

namespace GHL\Services;
use App\Models\OauthAccessToken;
use App\Models\Workspace;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fetch
{
    const BASE_URL = "https://services.leadconnectorhq.com";

    /**
     * @var string
     */
    private mixed $method;
    /**
     * @var array
     */
    private mixed $data;
    /**
     * @var array
     */
    private mixed $headers;

    public function __invoke($workspaceId, $url, $method = 'get', $data = null, $headers = [], $retries = 1)
    {
        $this->method = $method;
        $this->data = $data;

        /** @var OauthAccessToken $oauthToken */
        $oauthToken = Workspace::find($workspaceId)->oauth_token;
        $this->headers["Authorization"] = "{$oauthToken->token_type} {$oauthToken->access_token}";
        $response = $this->fetch($url);

        if($response->status() === 401 && $retries > 0)
        {
            $oauthToken->refresh();
            $this($workspaceId, $url, $method, $data, $headers, --$retries);
        }

        return $response;
    }

    private function fetch($url)
    {
        return Http::withHeaders([...$this->headers, 'Version' => '2021-07-28'])->{$this->method}(self::BASE_URL . $url, $this->data);
    }
}
