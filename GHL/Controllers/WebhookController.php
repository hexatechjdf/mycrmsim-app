<?php

namespace GHL\Controllers;

use App\Models\Workspace;
use GHL\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class WebhookController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function delivery(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Routing\ResponseFactory
    {

        $messageId = $request->messageId;
        $workspace = Workspace::where('remote_id', $request->locationId)->with("sims")->first();

        if(!$workspace)
            return response()->noContent(400);

        $contactPhone = $request->phone ?? null;
        $simId = $workspace->sims->first()?->id;

        if (!$contactPhone || !$simId) {
            $message = "";
            if(!$contactPhone)
                $message .= 'Phone number must exist to send message. ';
            if(!$simId)
                $message .= "No Phone number is attached with this location";

            $status = Api::STATUS["failed"];
            $message = json_encode($message);

            Process::path(base_path())->start("php artisan ghl:update-message-status --workspaceId={$workspace->id} --messageId={$messageId} --status={$status} --error={$message} &");

            return response(status: 400);
        }

        $attachments = $request->get('attachments', []);
        $response = \Gateway\Api::sendMessage($workspace->user_id, $simId, $request->message ?? " ", $contactPhone, $attachments);

        if ($response->success) {
            $gatewayMessageId = $response->data->messages[0]->ID;
            Cache::set($gatewayMessageId, (object)[
                "workspace_id" => $workspace->id,
                "message_id" => $messageId
            ]);

            return response(status: 200);
        } else {
            $status = Api::STATUS["failed"];
            $message = json_encode("Failed to send to Gateway.");

            Process::path(base_path())->start("php artisan ghl:update-message-status --workspaceId={$workspace->id} --messageId={$messageId} --status={$status} --error={$message} &");

            return response(status: 500);
        }
    }
}

