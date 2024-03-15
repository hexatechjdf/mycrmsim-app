<?php

namespace GHL\Controllers;

use GHL\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ConversationsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function update(Request $request): void
    {
        $request->validate([
            'workspaceId' => 'required',
            'messageId' => 'required',
            'status' => 'required'
        ]);

        [$workspaceId, $messageId, $status, $error] = $request->all();

        Api::updateMessageStatus($workspaceId, $messageId, $status, $error ?? null);
    }
}
