<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Accident extends Mailable
{
    use Queueable, SerializesModels;

    private string $constructionName;
    private string $date;
    private string $first_name;
    private string $last_name;

    public function __construct(string $constructionName, string $date, string $first_name, string $last_name)
    {
        $this->date = $date;
        $this->constructionName = $constructionName;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function build(): Accident
    {
        return $this->view('emails.accident')
            ->subject('Critical Building Tilt Notification')
            ->with([
                'firstName' => $this->first_name,
                'lastName' => $this->last_name,
                'constructionName' => $this->constructionName,
                'date' => $this->date
            ]);
    }
}
