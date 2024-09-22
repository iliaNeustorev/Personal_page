<?php

namespace App\Mail;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFeedback extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Feedback $feedback
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новый отзыв',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->feedback->load('user');
        return new Content(
            view: 'components.mails.new-feedback',
            with: [
                'name' => $this->feedback->user?->first_name . ' ' . $this->feedback->user?->last_name,
                'email' => $this->feedback->user?->email,
                'questionSubject' => $this->feedback->question_subject ?? 'Без темы',
                'question' => $this->feedback->question,
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
