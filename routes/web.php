<?php
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function(){ return redirect()->route('whatsapp.send'); });

Route::get('/send', [WhatsappController::class, 'showSend'])->name('whatsapp.send');
Route::post('/send', [WhatsappController::class, 'sendMessage'])->name('whatsapp.send.post');

Route::get('/inbox', [WhatsappController::class, 'inbox'])->name('whatsapp.inbox');

// Webhook endpoint (publica, Twilio hará POST aquí)
Route::post('/api/twilio/webhook', [WhatsappController::class, 'webhook'])->name('whatsapp.webhook');

// API para obtener mensajes recibidos


