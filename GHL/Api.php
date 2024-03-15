<?php

namespace GHL;

use App\Models\Workspace;
use GHL\Services\Fetch;
use Illuminate\Support\Facades\Log;

class Api
{
    CONST STATUS = [
        "read" => "read",
        "pending" => "pending",
        "delivered" => "delivered",
        "failed" => "failed"
    ];

    public static function getWorkspaceInfo($workspaceId): object|null
    {
        $return = null;
        $remoteId = Workspace::find($workspaceId)->remote_id;
        $response = (new Fetch())($workspaceId, "/locations/{$remoteId}");
        if($response->ok())
            $return = $response->object();

        return $return;
    }

    public static function updateMessageStatus($workspaceId, $messageId, $status, $error = null): bool
    {
        $data = [
            "status" => $status
        ];

        if($status === self::STATUS["failed"])
            $error = (object) $error ?? [];

        if(!is_null($error))
            $data["error"] = [
                "code" => $error->code ?? 1,
                "type" => "sass",
                "message" => $error->message ?? ""
            ];

        $response = (new Fetch())($workspaceId, "/conversations/messages/{$messageId}/status", 'put', $data);

        return $response->status() === 200;
    }

    public static function getContactInfo($workspaceId, $contactId)
    {
        $return = null;
        $response = (new Fetch())($workspaceId, "/contacts/{$contactId}");
        if($response->ok())
            $return = $response->object()->contact;

        return $return;
    }

    public static function searchContact($workspaceId, $searchQuery, $limit = 1)
    {
        $return = null;
        $workspaceRemoteId = Workspace::find($workspaceId)->remote_id;
        $query = http_build_query([
            "query" => $searchQuery,
            "limit" => $limit,
            "locationId" => $workspaceRemoteId,
        ]);
        $response = (new Fetch())($workspaceId, "/contacts/?$query");
        if($response->ok())
            $return = $response->object()->contacts;

        return $return;
    }

    public static function postInboundMessage($workspaceId, $conversationId, $message, $attachments = []): bool
    {
        $data = [
            "type" => "Custom",
            "conversationId" => $conversationId,
            "message" => $message,
            "conversationProviderId" => config("services.ghl.conversation_provider_id"),
            "direction" => "inbound"
        ];
        if(!empty($attachments))
            $data["attachments"] = $attachments;

        $response = (new Fetch())($workspaceId, "/conversations/messages/inbound", "post", data: $data);

        return $response->status() === 201;
    }

    public static function searchConversation($workspaceId, $contactId)
    {
        $return = null;
        $query = http_build_query([
            "contactId" => $contactId,
            "limit" => 1
        ]);
        $response = (new Fetch())($workspaceId, "/conversations/search?$query");
        if($response->ok())
            $return = $response->object()->conversations;

        return $return;
    }
}
