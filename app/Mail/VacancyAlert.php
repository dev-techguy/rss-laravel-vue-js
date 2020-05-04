<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $company;
    /**
     * @var string
     */
    private $description;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $company
     * @param string $description
     */
    public function __construct(string $name, string $company, string $description)
    {
        $this->name = $name;
        $this->company = $company;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vacancy-alert', [
            'name' => $this->name,
            'company' => $this->company,
            'description' => $this->description,
        ]);
    }
}
