<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class hse extends Mailable
{
    use Queueable, SerializesModels;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'nama'  => Auth::user()->name,
            'user' =>  DB::table('users')->where('role',3)->orderBy('id')->first(),
            'observasi' =>  DB::table('hseobs')->orderBy('id_hseobs','desc')->first()
        ];
        return $this->subject('Konfirmasi Status User Area Mananger')
                    ->view('auth.passwords.pesan_mananger',$data);
    }
}
