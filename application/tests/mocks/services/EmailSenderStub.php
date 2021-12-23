<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

use Faker\Factory as Faker;

class EmailSenderStub implements EmailSenderInterface
{
	private $faker;

	public function __construct()
	{
		$this->faker = Faker::create();
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
		return true;
	}

	public function sendEmailCorrectly(): bool
	{
		return $this->sendEmail(
			$this->faker->email(),
			$this->faker->realText(30),
			$this->faker->companyEmail(),
			'html',
			$this->faker->randomHtml(50),
			$this->faker->name('male'),
			$this->faker->company()
		);
	}

	public function sendEmailFailed(): bool
	{
		$this->sendEmail(
			$this->faker->email(),
			$this->faker->realText(30),
			$this->faker->companyEmail(),
			'html',
			$this->faker->randomHtml(50),
			$this->faker->name('male'),
			$this->faker->company()
		);

		return false;
	}
}
