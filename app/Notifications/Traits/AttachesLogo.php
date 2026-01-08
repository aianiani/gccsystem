<?php

namespace App\Notifications\Traits;

trait AttachesLogo
{
    /**
     * Attach the logo to the mail message.
     */
    protected function attachLogo($mailMessage)
    {
        $logoPath = public_path('images/logo.jpg');

        if (file_exists($logoPath)) {
            $mailMessage->attach($logoPath, [
                'as' => 'logo.jpg',
                'mime' => 'image/jpeg',
            ])->embedData(file_get_contents($logoPath), 'logo', 'image/jpeg');
        }

        return $mailMessage;
    }
}
