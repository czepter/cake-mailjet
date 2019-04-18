<?php

namespace CakeMailjet\Mailer\Transport;

use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Email;

use Mailjet\Client;
use Mailjet\Resources;

class MailjetTransport extends AbstractTransport
{
    public function send(Email $email)
    {
		if (!empty($this->_config['mailjet'])) {
			$this->_config = $this->_config['mailjet'] + $this->_config;
			$email->setConfig((array)$this->_config['mailjet'] + ['mailjet' => []]);
			unset($this->_config['mailjet']);
		}
		$headers = $email->getHeaders();

		$mailjetClient = new Client(
            $this->_config['apiKey'],
            $this->_config['apiSecret'],
            TRUE,
            ['version' => 'v3.1']
        );
        $message = ['Subject' => $email->subject()];
        foreach ($email->from() as $fromEmail => $name)
        {
            $message['From'] = ['Email' => $fromEmail, 'Name' => $name];
        }
        foreach ($email->to() as $toEmail => $name)
        {
            $message['To'][] = ['Email' => $toEmail, 'Name' => $name];
        }
        foreach ($email->attachments() as $name => $info)
        {
            $message['Attachments'][] = [
                'ContentType'   => $info['mimetype'],
                'Filename'      => $name,
                'Base64Content' => base64_encode(file_get_contents($info['file']))
            ];
        }

        /**
         * Mailjet TemplateID used, set TemplateID, TemplateVars
         * and TemplateLanguage
         */
        if (isset($headers['TemplateID']) && intval($headers['TemplateID']) > 0)
        {
            $message['TemplateLanguage'] = TRUE;
            $message['TemplateID']       = intval($headers['TemplateID']);
            $message['Variables']        = $email->viewVars();
        }
        else
        {
            $format = $email->emailFormat();
            switch ($format)
            {
                case 'text':
                    $message['TextPart'] = $email->message(Email::MESSAGE_TEXT);
                    break;
                case 'html':
                    $message['HTMLPart'] = $email->message(Email::MESSAGE_HTML);
                    break;
                default:
                    $message['TextPart'] = $email->message(Email::MESSAGE_TEXT);
                    $message['HTMLPart'] = $email->message(Email::MESSAGE_HTML);
                    break;
            }
        }
        $body = [
            'Messages' => [$message]
        ];

		if(isset($headers['Sandbox']))
			if($headers['Sandbox'])
				$body['Sandbox'] = true;


        try
        {
            $result = $mailjetClient->post(Resources::$Email, ['body' => $body]);
            if ($result->success() != TRUE)
            {
                throw new Exception($result->getReasonPhrase());
            }
        }
        catch (Exception $e)
        {
            throw $e;
        }
        return [
			'response' => $result->success(),
			'result' => $result->getData()
		];
     }
}
