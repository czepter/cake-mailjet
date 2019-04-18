<?php
return [

	'EmailTransport' => [
		'default' => [
			'className' => 'Smtp',
			// The following keys are used in SMTP transports
			'host' => 'ssl://smtp.example.org',
			'port' => 465,
			'timeout' => 30,
			'username' => 'user@example.org',
			'password' => 'secret',
			'client' => null,
			'tls' => null,
			'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
		],
		'mailjet' => [
			'className' => 'CakeMailjet.Mailjet',
			'apiKey' => 'your-api-key',
			'apiSecret' => 'your-api-secret'
		]
	],

	/**
	* Email delivery profiles
	*
	* Delivery profiles allow you to predefine various properties about email
	* messages from your application and give the settings a name. This saves
	* duplication across your application and makes maintenance and development
	* easier. Each profile accepts a number of keys. See `Cake\Mailer\Email`
	* for more information.
	*/
	'Email' => [
		'default' => [
			'transport' => 'mailjet',
			'from' => 'no-reply@minutes-crm.de',
			'charset' => 'utf-8',
			'headerCharset' => 'utf-8',
			],
		]
	];
