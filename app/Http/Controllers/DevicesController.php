<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Gateway\Api;
use Gateway\Api as GatewayApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DevicesController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show(Request $request): View
    {
        $devices = GatewayApi::getDevices($request->user()->id);

        return view("devices", compact("devices"));
    }

    public function edit(Request $request)
    {
        $message = "Failed";

        $request->validate([
            "deviceId" => "required",
            "name" => "required"
        ]);

        $response = Api::editDevice($request->deviceId, $request->name);

        if($response)
            $message = 'Success';

        return back()->with(["message" => $message]);
    }

    public function destroy(Request $request)
    {
        $message = "Failed";
        $request->validate([
            "devices" => "required|array"
        ]);

        $response = Api::removeDevices($request->devices);

        if($response)
        {
            Sim::whereIn("gateway_device_id", $request->devices)->whereIn("workspace_id", Auth::user()->workspaces->pluck("id"))->delete();
            $message = 'Success';
        }

        return back()->with(["message" => $message]);
    }
}
