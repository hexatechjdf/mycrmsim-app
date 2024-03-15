<?php

namespace Gateway;

use App\Models\Sim;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GHL\Api as GHLApi;

class Api
{
    CONST STATUS = [
        "Sent" => GHLApi::STATUS["delivered"],
        "Failed" => GHLApi::STATUS["failed"]
    ];

    CONST BASE_URL = "https://gateway.jdftest.xyz";

    public static function createUser(): int|null
    {
        $return = null;

        $response = Http::withHeaders([
            "X-Requested-With" => "XMLHttpRequest"
        ])->asForm()->post(self::BASE_URL . '/ajax/register-user.php', [
            'name' => 'lead_message_user',
            'email' => "email." . time() . "@leadtalk.com"
        ]);

        if($response->ok())
        {
            $response = $response->object();
            if(!property_exists($response, "error"))
                $return = $response->user_id;
        }

        return $return;
    }

    public static function getQRCode($userId = null): ?string
    {
        if (!$userId)
            $userId = Auth::user()->id;

        $userId = User::find($userId)->gateway_id;

        $return = null;
        $response = Http::get(self::BASE_URL . "/qr-code.php?user={$userId}&client_slug=laravel&user_id={$userId}");
        if($response->ok())
        {
            $return = base64_encode($response->body());
        }

        return $return;
    }

    public static function getDevices($userId)
    {
        $userId = User::find($userId)->gateway_id;
        $return = null;
        $response = Http::get(self::BASE_URL . "/services/get-devices.php?client_slug=laravel&user_id={$userId}");

        if($response->ok())
        {
            $return = $response->object()->data->devices;
        }

        return $return;
    }

    public static function sendMessage($userId, int $simId, string $message, string $phone, array $attachments = []): object
    {
        $type = empty($attachments) ? 'sms' : 'mms';
        $gatewayUserId = User::find($userId)->gateway_id;
        $sim = Sim::findOrFail($simId);
        $deviceId = $sim->gateway_device_id;
        $simSlot = $sim->gateway_slot;

        $data = [
            'devices' => "{$deviceId}|{$simSlot}",
            'type' => $type,
            'number' => $phone,
            'message' => $message,
            'attachments' => implode(",", $attachments)
        ];

        $response = Http::get(self::BASE_URL . "/services/send.php?client_slug=laravel&user_id={$gatewayUserId}&" . http_build_query($data));

        return $response->object();
    }

    public static function editDevice(int $deviceId, string $name): bool
    {
        $gatewayUserId = Auth::user()->gateway_id;

        $response = Http::withHeaders([
            "X-Requested-With" => "XMLHttpRequest"
        ])->asForm()->post(self::BASE_URL . "/ajax/edit-device.php?client_slug=laravel&user_id={$gatewayUserId}", [
            "name" => $name,
            "deviceID" => $deviceId
        ]);

        return !property_exists($response->object(), "error");
    }


    public static function removeDevices(array $devices): bool
    {
        $gatewayUserId = Auth::user()->gateway_id;

        $response = Http::withHeaders([
            "X-Requested-With" => "XMLHttpRequest"
        ])->asForm()->post(self::BASE_URL . "/ajax/remove-devices.php?client_slug=laravel&user_id={$gatewayUserId}", [
            "devices" => $devices
        ]);

        return !property_exists($response->object(), "error");
    }
}

