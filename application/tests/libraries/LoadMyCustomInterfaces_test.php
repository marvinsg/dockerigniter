<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

class LoadMyCustomInterfaces_test extends TestCase
{
	private LoadMyCustomInterfaces $mock;

	protected function setUp(): void
	{
		$this->mock = new LoadMyCustomInterfaces();
	}

	public function test_all_custom_interfaces_are_loaded(): void
	{
		require_once(FCPATH . '/application/tests/mocks/services/EmailSenderStub.php');

		$emailSenderStub = new EmailSenderStub();

		$this->assertNotNull($emailSenderStub);
		$this->assertTrue($emailSenderStub->sendEmailCorrectly());
		$this->assertFalse($emailSenderStub->sendEmailFailed());
	}
}
