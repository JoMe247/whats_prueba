<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappController;

Route::post('/twilio/webhook', [WhatsappController::class, 'webhook']);
