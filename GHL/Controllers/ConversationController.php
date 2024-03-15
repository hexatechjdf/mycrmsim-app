<?php

namespace GHL\Controllers;

use GHL\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ConversationController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function updateStatus(Request $request): void
    {
        $request->validate([
            'workspaceId' => 'required',
            'messageId' => 'required',
            'status' => 'required'
        ]);

        Api::updateMessageStatus($request->workspaceId, $request->messageId, $request->status, $request->get("error"));
    }
}
