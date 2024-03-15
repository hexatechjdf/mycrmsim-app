<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use App\Models\Workspace;
use Closure;
use Gateway\Api as GatewayApi;
use GHL\Api as GHLApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;

class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show(Request $request)
    {

        $workspaces = Workspace::where("user_id", $request->user()->id)->with("sims")->get();

        $workspaces->each(function ($i) {
           $i->name = Arr::get($i->meta, "name");
        });

        $devices = GatewayApi::getDevices($request->user()->id);

        return view("dashboard", compact("workspaces", "devices"));
    }

    public function saveSims(Request $request, Workspace $workspace): RedirectResponse
    {
        $message = 'Success';
        $request->validate([
            "sim-select" => ["nullable", "string", function (string $attribute, mixed $value, Closure $fail)
            {
                if(!(count($parts = explode('|', $value)) === 2 && ctype_digit($parts[0]) && ctype_digit($parts[1]))) {
                    $fail("The {$attribute} is invalid.");
                }
            }]
        ]);

        if(is_null($request->get('sim-select')))
        {
            $workspace->sims()->delete();
        } else {
            [$gatewayDeviceId, $gatewaySlot] = explode("|", $request->get('sim-select'));

            if(!Sim::where("gateway_slot", $gatewaySlot)->where("gateway_device_id", $gatewayDeviceId)->exists())
            {
                if($workspace->sims->count())
                    $workspace->sims()->update([
                        "gateway_device_id" => $gatewayDeviceId,
                        "gateway_slot" => $gatewaySlot
                    ]);
                else
                    $workspace->sims()->create([
                        "gateway_device_id" => $gatewayDeviceId,
                        "gateway_slot" => $gatewaySlot
                    ]);
            } else
                $message = 'Sim is attached with other workspace';

        }

        return back()->with(['message' => $message]);
    }

}
