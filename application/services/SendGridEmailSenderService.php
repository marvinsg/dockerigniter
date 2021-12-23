<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

use SendGrid\Mail\Mail;

final class SendGridEmailSenderService implements EmailSenderInterface
{
	private const DEFAULT_CONTENT_TYPE = 'html';
	private const CONTENT_TYPES        = ['text' => 'text/plain', 'html' => 'text/html'];
	private const ACCEPTED_HTTP_CODE   = 202;

	private CI_Controller $CI;
	private Mail          $sendgridMailInstance;
	private SendGrid      $sendgridInstance;

	public function __construct()
	{
		$this->CI                   = &get_instance();
		$this->sendgridMailInstance = new Mail();
		$this->sendgridInstance     = new SendGrid($_ENV['SENDGRID_API_KEY']);
	}

	public function sendEmail(
		string $from,
		string $subject,
		string $to,
		string $contentType,
		string $content,
		string $nameFrom = null,
		string $nameTo = null,
		array $cc = null,
		array $bcc = null,
		array $attachments = null
	): bool {
		try {
			$this->sendgridMailInstance->setFrom($from, $nameFrom);
			$this->sendgridMailInstance->setSubject($subject);
			$this->sendgridMailInstance->addTo($to, $nameTo);
			if (!array_key_exists($contentType, self::CONTENT_TYPES)) {
				$contentType = self::DEFAULT_CONTENT_TYPE;
			}
			$this->sendgridMailInstance->addContent(self::CONTENT_TYPES[$contentType], $content);

			if(!is_null($cc)) {
				foreach($cc as $eachCc){
					$this->sendgridMailInstance->addCc($eachCc);
				}
			}

			if(!is_null($bcc)) {
				foreach($bcc as $eachBcc){
					$this->sendgridMailInstance->addBcc($eachBcc);
				}
			}

			if(!is_null($attachments)) {
				foreach($attachments as $eachAttachment){
					$file_encoded = base64_encode(file_get_contents($eachAttachment['filepath']));
					$this->sendgridMailInstance->addAttachment(
						$file_encoded,
						mime_content_type($eachAttachment['filepath']),
						$eachAttachment['filename'],
						"attachment"
					);
				}
			}

			$response = $this->sendgridInstance->send($this->sendgridMailInstance);

			if($response->statusCode() !== self::ACCEPTED_HTTP_CODE){
				log_message('error', 'SENDGRID TRACE: STATUS CODE: '.$response->statusCode().' BODY: '.$response->body());
				return false;
			}
		} catch (Exception $e) {
			log_message('error', 'SENDGRID EXCEPTION TRACE: '.$e->getMessage());
		}

		return true;
	}
}
