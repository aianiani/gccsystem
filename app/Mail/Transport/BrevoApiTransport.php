<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoApiTransport extends AbstractTransport
{
    protected ?string $apiKey;

    public function __construct(?string $apiKey)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
    }

    protected function doSend(SentMessage $message): void
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Brevo API key is not configured. Please set the BREVO_API_KEY environment variable.');
        }

        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $sender = $email->getFrom()[0] ?? null;
        $senderData = $sender ? [
            'email' => $sender->getAddress(),
            'name' => $sender->getName() ?: null,
        ] : [
            'email' => config('mail.from.address'),
            'name' => config('mail.from.name'),
        ];

        $toData = [];
        foreach ($email->getTo() as $recipient) {
            $toData[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }

        $payload = [
            'sender' => $senderData,
            'to' => $toData,
            'subject' => $email->getSubject(),
        ];

        // Handle CC
        $ccData = [];
        foreach ($email->getCc() as $recipient) {
            $ccData[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }
        if (!empty($ccData)) {
            $payload['cc'] = $ccData;
        }

        // Handle BCC
        $bccData = [];
        foreach ($email->getBcc() as $recipient) {
            $bccData[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }
        if (!empty($bccData)) {
            $payload['bcc'] = $bccData;
        }

        // Body Content
        $html = $email->getHtmlBody();
        if ($html !== null) {
            $payload['htmlContent'] = is_resource($html) ? stream_get_contents($html) : $html;
        }

        $text = $email->getTextBody();
        if ($text !== null) {
            $payload['textContent'] = is_resource($text) ? stream_get_contents($text) : $text;
        }

        // Send via Brevo API (port 443 HTTPS, which is not blocked by Render Free plan)
        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            Log::error('Brevo API Mail failed: ' . $response->body());
            throw new \Exception('Brevo API Email sending failed: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
