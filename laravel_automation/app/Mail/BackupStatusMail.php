<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $success;
    public $fileName;
    public $errorMessage;
    /**
     * Create a new message instance.
     */
    public function __construct($success, $fileName = '', $errorMessage = '')
    {
        //
        $this->success = $success;
        $this->fileName = $fileName;
        $this->errorMessage = $errorMessage;
    }





    public function build()
    {
        return $this->subject($this->success ? 'Database Backup Successful' : 'Database Backup Failed')
            ->view('emails.backup-status');
    }
}
