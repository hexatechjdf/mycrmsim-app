<?php

use GHL\Controllers\AuthController;
use GHL\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('auth/callback', [AuthController::class, 'callback'])->name("auth.callback");
Route::post('webhook/delivery', [WebhookController::class, 'delivery']);


