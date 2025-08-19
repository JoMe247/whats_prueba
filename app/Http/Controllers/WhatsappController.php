<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Twilio\Rest\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid') ?: env('TWILIO_SID');
        $token = config('services.twilio.token') ?: env('TWILIO_AUTH_TOKEN');
        $this->twilio = new Client($sid, $token);
    }

    // Mostrar formulario de envío
    public function showSend()
    {
        return view('send');
    }

    // Procesar envío desde el formulario
    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'to' => 'required|string',   // número destino con prefijo internacional, ej: +521XXXXXXXXXX
            'body' => 'required|string',
        ]);

        $from = env('TWILIO_WHATSAPP_NUMBER'); // ej: whatsapp:+1415XXXXXXX

        try {
            // Twilio requiere el prefijo 'whatsapp:' en los números
            $to = 'whatsapp:' . ltrim($data['to'], '+'); // si ingresaron +521... -> whatsapp:521...

            $message = $this->twilio->messages->create(
                $to,
                [
                    'from' => $from, // debe ser 'whatsapp:+...'
                    'body' => $data['body']
                ]
            );

            // Guardar en DB como 'out'
            Message::create([
                'from' => $from,
                'to' => $to,
                'body' => $data['body'],
                'direction' => 'out',
                'twilio_sid' => $message->sid ?? null,
                'received_at' => Carbon::now(),
            ]);

            return redirect()->route('whatsapp.send')->with('success', 'Mensaje enviado correctamente.');
        } catch (\Throwable $e) {
            Log::error('Twilio send error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error enviando mensaje: ' . $e->getMessage()]);
        }
    }

    // Webhook que Twilio llamará cuando llegue un mensaje (incoming)
    // Configura tu webhook en Twilio con la URL de ngrok -> /twilio/webhook
    public function webhook(Request $request)
    {
        // Twilio envía POST form params: From, To, Body, MessageSid, etc.
        $from = $request->input('From'); // ej: whatsapp:+521...
        $to = $request->input('To');
        $body = $request->input('Body');
        $sid = $request->input('MessageSid');

        // Guardar en BD
        $msg = Message::create([
            'from' => $from,
            'to' => $to,
            'body' => $body,
            'direction' => 'in',
            'twilio_sid' => $sid,
            'received_at' => Carbon::now(),
        ]);

        // Responder con TwiML (opcional) — responde vacio o con un mensaje
        $responseMessage = "Gracias, tu mensaje fue recibido.";
        $xml = "<?xml version='1.0' encoding='UTF-8'?><Response><Message>$responseMessage</Message></Response>";

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    // Mostrar inbox (historial)
    public function inbox()
    {
        $accountSid = env('TWILIO_SID');
        $authToken  = env('TWILIO_AUTH_TOKEN');
        $fromWa     = env('TWILIO_WHATSAPP_FROM');

        $client = new Client($accountSid, $authToken);

        // Traer últimos 100 mensajes recibidos
        $messages = $client->messages->read(['to' => $fromWa], 100);

        return view('inbox', compact('messages', 'fromWa'));
    }
}
