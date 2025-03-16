<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Topup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DetailTopupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $topup;

    /**
     * Create a new message instance.
     */
    public function __construct(Topup $topup)
    {
        $this->topup = $topup;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->topup->status;
        $number = $this->topup->number;
        $subject = "Information Payment Topup Account, Ref No $number";
        if ($status == 'cancel') {
            $subject = "Topup Account Canceled, Ref No $number";
        } elseif ($status == 'done') {
            $subject = "Topup Account Success, Ref No $number";
        }
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.detail_topup',
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

    public function build()
    {
        $company = Company::first();
        $topup = $this->topup->load(['bank', 'user']);
        $from = config('mail.from.address');
        return $this->from($from, $company->name)
            ->with([
                'company'   => $company,
                'topup'     => $topup
            ]);
    }
}
