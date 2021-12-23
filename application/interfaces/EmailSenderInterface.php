<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

interface EmailSenderInterface
{
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
	): bool;
}
