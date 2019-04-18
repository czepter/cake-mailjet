# Mailjet plugin for CakePHP

Allows sending emails via Mailjet by using the provided Mailjet SDK.

## Requirements
PHP >= 7.0
CakePHP >= 3.7
Composer

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require czepter/mailjet
```

load this plugin into your src/AppController.php with:

```
bin/cake plugin load Mailjet
```

or modify the file by your own inside of bootstrap():

``` php
$this->addPlugin('Mailjet');
```

## Example configuration

example content of your config/app.php:

```php
'EmailTransport' => [
	'default' => [
		...
	],
	'mailjet' => [
		'className' => 'Mailjet.Mailjet',
		'apiKey' => 'your-api-key',
		'apiSecret' => 'your-api-secret'
	]
],

'Email' => [
	'default' => [
		'transport' => 'mailjet',

		'from' => 'no-reply@example.org',
		'charset' => 'utf-8',
		'headerCharset' => 'utf-8',
		],
	]
];
```

## Email setup

to write a mail using the templates use the following configuration in your Mailer class:

```php
$email
   ->emailFormat('html')
   ->subject('some text')
   ->to('hi@example.org')
   ->from('app@example.org')
   ->addHeaders([
	   'TemplateID' => 123456,
   ])
   ->setViewVars([
	   "greetings" => "a text wich replaces the var:greetings in your template",
	   ...
   ])
   ->send();
```
