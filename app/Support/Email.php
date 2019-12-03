<?php

namespace App\Support;

use stdClass;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
	private $mail;

	private $data;

	private $error;

	public function __construct()
	{
		$this->mail = new PHPMailer(true);
		$this->data = new stdClass();

		$this->mail->isSMTP();
		$this->mail->isHTML();
		$this->mail->setLanguage('en');

		$this->mail->SMTPAuth 	= (bool) true;
		$this->mail->SMTPSecure = 'ssl';
		$this->mail->charset 	= 'utf-8';
		$this->mail->SMTPDebug 	= (int) 2;

		$this->mail->Host 		= 'smtp.sendgrid.net';
		$this->mail->Port 		= 465;
		$this->mail->Username 	= 'apikey';
		$this->mail->Password 	= '';
	}

	public function add($subject, $body, $recipientName, $recipientEmail)
	{
		$this->data->subject 		= $subject;
		$this->data->body 			= $body;
		$this->data->recipientName 	= $recipientName;
		$this->data->recipientEmail = $recipientEmail;

		return $this;
	}

	public function send()
	{
		try {
			$this->mail->Subject = $this->data->subject;
			$this->mail->msgHTML($this->data->body);
			$this->mail->addAddress($this->data->recipientEmail, $this->data->recipientName);
			$this->mail->setFrom('no-reply@ocfa.com', 'Orange County Fire Authority');

			$this->mail->send();

			return true;
		} catch (\Exception $e) {
			$this->error = $e;
			return false;
		}
	}

	public function failed()
	{
		return $this->error;
	}
}