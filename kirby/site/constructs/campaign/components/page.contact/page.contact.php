<?php
use Uniform\Form;
return function ($site, $pages, $page) {

	$form = new Form([
		'email' => [
			'rules' => ['required', 'email'],
			'message' => l::get('contactForm.email.error'),
		],
		'salutation' => [
			'rules' =>  ['in' => [[l::get('contactForm.salutationMs'), l::get('contactForm.salutationMr')]]],
			'message' => l::get('contactForm.salutation.error'),
		],
		'name' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.name.error'),
		],
		'surname' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.surname.error'),
		],
		'address' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.address.error'),
		],
		'zip' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.zip.error'),
		],
		'city' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.city.error'),
		],
		'message' => [
			'rules' => ['required'],
			'message' => l::get('contactForm.message.error'),
		],
		'phone' => [],
		'source' => [],
	]);
	if (r::is('POST')) {
		$form->emailAction([
			'to' => c::get('contact-form-recipient'),
			'from' => get('email'),
			'subject' => l::get('contactForm.mailSubjectAdmin'),
			'snippet' => 'constructs/campaign/mail-templates/contact-form-admin',
		])
		->emailAction([
			'to' => get('email'),
			'from' => c::get('contact-form-recipient'),
			'subject' => l::get('contactForm.mailSubjectUser'),
			'snippet' => 'constructs/campaign/mail-templates/contact-form-user',
		]);

		if ($form->success()) {
			$url = $page->thanksPage()->toUrl();
			go($url);

		}
	}

	return compact('form');
};
