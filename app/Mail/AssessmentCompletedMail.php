<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssessmentCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $assessment;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Assessment $assessment)
    {
        $this->user = $user;
        $this->assessment = $assessment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assessment Completed - ' . $this->assessment->type . ' - CMU Guidance Center',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.assessment-completed',
            with: [
                'user' => $this->user,
                'assessment' => $this->assessment,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
