<?php

namespace App\Http\Dashboard\Notifications;

use Twilio\Rest\Client;
use App\Http\Container;
use App\Domain\Log;
use App\Domain\Group;
use App\Domain\Notification;
use Respect\Validation\Validator as v;

class CreateController extends Container
{
	private $twilio;

	public function __construct($container)
	{
		parent::__construct($container);

		$this->twilio = new Client(
			'',
			''
		);
	}

	public function get($request, $response, $args)
	{
		return $this->render('dashboard.notifications.create', [
			'groups' => Group::all(),
		]);
	}

	public function post($request, $response, $args)
	{
		$validation = $this->validator->validate($request, [
			'subject' 	=> v::notEmpty(),
			'message' 	=> v::notEmpty(),
			'groups' 	=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		$notification = Notification::create([
			'user_id' => $this->auth->user()->id,
			'subject' => $request->getParam('subject'),
			'message' => $request->getParam('message'),
		]);

		$notification->groups()->sync($request->getParam('groups'));

		foreach ($notification->groups as $group)
		{
			foreach ($group->contacts as $contact)
			{
				if ($contact->preference == 'email') {
					$this->sendEmail($notification, $contact);
				}

				if ($contact->preference == 'phone') {
					$this->sendSMS($notification, $contact);
				}

				if ($contact->preference == 'both') {
					$this->sendEmail($notification, $contact);
					$this->sendSMS($notification, $contact);
				}
			}
		}

		flash('success', 'Notification created!');
		return redirect(
			$this->router->pathFor('dashboard.notifications.home')
		);
	}

	private function sendEmail($notification, $contact)
	{
		$mailer = new \App\Support\Email();
		$email = $mailer->add(
			$notification->subject,
			$notification->message,
			$contact->name,
			$contact->email
		);

		if (! $email->send()) {
			Log::create([
				'error' => 'email',
				'message' => 'Could not send email to ' . $contact->email,
			]);
		}
	}

	private function sendSMS($notification, $contact)
	{
		try {
			$this->twilio->messages->create($contact->phone, [
				'from' => '',
				'body' => $notification->subject . ': ' . $notification->message,
			]);	
		} catch (\Twilio\Exceptions\RestException $e) {
			Log::create([
				'error' 	=> 'SMS',
				'message' 	=> $e->getMessage(),
			]);
		}
	}
}