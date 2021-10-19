<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mananger extends Mailable
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
            // 'observasi' =>  DB::table('hseobs')->orderBy('id_hseobs','desc')->first()
            'data_cabang' =>  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->join('users', 'users.id', '=', 'hseobs.user_id')->where('hse_nik', Auth::user()->email)->first()
        ];
        return $this->subject('Konfirmasi Status User Pengawas')
                    ->view('auth.passwords.message_mananger',$data);
    }
}
