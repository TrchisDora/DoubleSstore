<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRegisterSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $password;

    public function __construct($admin, $password)
    {
        $this->admin = $admin;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('AdminPages.Pages.auth.emails.register_success')
                    ->with([
                        'admin' => $this->admin,
                        'password' => $this->password,
                    ]);
    }
}
