<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserSendNewpassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from : new Address('notificacion@cms.com','MyCMS'),
            subject: 'Su nueva contraseña',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //return $this->from(env('MAIL_FROM'), env('APP_NAME'))
        //            ->view('emails.user_password_recover')
        //            ->subject('Recuperar su Contraseña')
        //            ->with($this->data);

        return new Content(
            view :'emails.user_send_new_password',
            with : $this->data,
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
