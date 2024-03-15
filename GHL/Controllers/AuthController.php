<?php

namespace GHL\Controllers;

use App\Models\OauthAccessToken;
use App\Models\User;
use App\Models\Workspace;
use App\Providers\RouteServiceProvider;
use Gateway\Api;
use GHL\Api as GHLApi;
use GHL\Services\Fetch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function callback(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(["code" => "required"]);

        $response = Http::asForm()->post("https://services.leadconnectorhq.com/oauth/token", [
            "client_id" => config("services.ghl.key"),
            "client_secret" => config("services.ghl.secret"),
            "grant_type" => "authorization_code",
            "code" => $request->code
        ]);

        if($response->ok())
        {
            $body = $response->object();

            $locationInfo = Http::withHeaders([
                "Authorization" => "{$body->token_type} {$body->access_token}",
                "Version" => "2021-07-28"
            ])->get(Fetch::BASE_URL . "/locations/{$body->locationId}")->object()->location;
            $locationEmail = $locationInfo->email;

            $user = User::where("email", $locationEmail)->first();

            if(!$user)
            {
                $gatewayId = Api::createUser();
                if($gatewayId == null) return response()->json(["message" => "Please install again.", 500]);

                $user = User::create([
                    "email" => $locationEmail,
                    "gateway_id" => $gatewayId
                ]);
            }

            $workspace = Workspace::where('remote_id', $body->locationId)->first();
            if(!$workspace)
            {
                $workspace = Workspace::create([
                    "user_id" => $user->id,
                    "remote_id" => $body->locationId,
                    "meta" => $locationInfo
                ]);
            }

            $workspace->oauth_token()->updateOrCreate([], [
                "access_token" => $body->access_token,
                "refresh_token" => $body->refresh_token,
                "token_type" => $body->token_type,
                "scope" => $body->scope,
                "workspace_id" => $workspace->id,
                "installed_by" => $body->userId
            ]);

            Auth::login($user, true);

            return redirect(RouteServiceProvider::HOME);
        }

        return response()->json(["message" => "Please install again"], 400);
    }
}
