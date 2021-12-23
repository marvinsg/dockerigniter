<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

final class PHPMailerEmailSenderService implements EmailSenderInterface
{
	private const CONTENT_TYPE_HTML = 'html';
	private const CONTENT_TYPE_TEXT = 'text';
	private const DEFAULT_CONTENT_TYPE = self::CONTENT_TYPE_HTML;
	private const CONTENT_TYPES        = [self::CONTENT_TYPE_HTML, self::CONTENT_TYPE_TEXT];

	private CI_Controller $CI;
	private PHPMailer $phpMailerInstance;

	public function __construct()
	{
		$this->CI                   = &get_instance();
		//Create an instance; passing `true` enables exceptions
		$this->phpMailerInstance    = new PHPMailer(true);
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
			$this->phpMailerInstance->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$this->phpMailerInstance->isSMTP();                                            //Send using SMTP
			$this->phpMailerInstance->Host       = $_ENV['PHPMAILER_SMTP_HOST'];           //Set the SMTP server to send through
			$this->phpMailerInstance->SMTPAuth   = $_ENV['PHPMAILER_SMTP_AUTH'];           //Enable SMTP authentication
			$this->phpMailerInstance->Username   = $_ENV['PHPMAILER_SMTP_USERNAME'];       //SMTP username
			$this->phpMailerInstance->Password   = $_ENV['PHPMAILER_SMTP_PASSWORD'];       //SMTP password
			$this->phpMailerInstance->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$this->phpMailerInstance->Port       = $_ENV['PHPMAILER_SMTP_PORT'];           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			//Recipients
			$this->phpMailerInstance->setFrom($from, $nameFrom);
			$this->phpMailerInstance->addAddress($to, $nameTo);      //Add a recipient (Name is optional)
			//$this->phpMailerInstance->addReplyTo('info@example.com', 'Information');

			if(!is_null($cc)) {
				foreach($cc as $eachCc){
					$this->phpMailerInstance->addCC($eachCc);
				}
			}

			if(!is_null($bcc)) {
				foreach($bcc as $eachBcc){
					$this->phpMailerInstance->addBCC($eachBcc);
				}
			}

			//Attachments
			if(!is_null($attachments)) {
				foreach($attachments as $eachAttachment){
					//Add attachments (Optional name)
					$this->phpMailerInstance->addAttachment($eachAttachment['filepath'], $eachAttachment['filename']);
				}
			}

			//Content
			if (!in_array($contentType, self::CONTENT_TYPES)) {
				$contentType = self::DEFAULT_CONTENT_TYPE;
			}

			$this->phpMailerInstance->isHTML(true);
			$this->phpMailerInstance->Body    = $content;

			if($contentType !== self::CONTENT_TYPE_HTML){
				$this->phpMailerInstance->isHTML(false);
				$this->phpMailerInstance->AltBody = $content;
			}

			$this->phpMailerInstance->Subject = $subject;

			$resultOfSending = $this->phpMailerInstance->send();

		} catch (Exception $e) {
			log_message('error', 'PHPMAILER EXCEPTION TRACE 1: '.$this->phpMailerInstance->ErrorInfo);
			log_message('error', 'PHPMAILER EXCEPTION TRACE 2: '.$e->getMessage());
		}

		return $resultOfSending;
	}
}
