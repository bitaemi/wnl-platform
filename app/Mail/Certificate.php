<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class Certificate extends Mailable
{
	use Queueable, SerializesModels;
	public $user;
	protected $file;

	/**
	 * Create a new message instance.
	 *
	 * @param $file
	 */
	public function __construct($file, $user, $type)
	{
		$this->file = Storage::disk('s3')->get($file);
		$this->user = $user;
		$this->type = $type;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$firstName = title_case(trim($this->user->first_name));
		$lastName = title_case(trim($this->user->last_name));
		$fileName = "Certyfikat_{$firstName}_{$lastName}.pdf";

		$subjects = [
			'final' => 'Certyfikat ukończenia kursu - Więcej niż LEK',
			'initial' => 'Certyfikat uczestnictwa - Więcej niż LEK',
		];

		return $this
			->view('mail.certificate-' . $this->type)
			->subject($subjects[$this->type])
			->attachData($this->file, $fileName, [
				'mime' => 'application/pdf',
			])
			->bcc('zamowienia@wiecejnizlek.pl');
	}
}
