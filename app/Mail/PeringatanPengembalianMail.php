<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeringatanPengembalianMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $hariTelat;

    public function __construct($peminjaman, $hariTelat)
    {
        $this->peminjaman = $peminjaman;
        $this->hariTelat = $hariTelat;
    }

    public function build()
    {
        return $this->subject('Peringatan Keterlambatan Pengembalian Alat')
                    ->view('emails.peringatan_pengembalian');
    }
}
