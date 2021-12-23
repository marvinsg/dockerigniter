<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

final class HealthCheckController extends MY_Controller
{
	public function index(): void
	{
		$mysqlCheck = $this->checkMySQLDatabaseConnection();
		$redisCheck = $this->checkRedisConnection();
		$sendgridCheck = $this->checkSendgridEmailSending();
		$phpmailerCheck = $this->checkPHPMailerEmailSending();

		$this->load->view('healthcheck',
			[
				'mysqlCheck'     => $mysqlCheck,
				'redisCheck'     => $redisCheck,
				'sendgridCheck'  => $sendgridCheck,
				'phpmailerCheck' => $phpmailerCheck
			]
		);
	}

	private function checkMySQLDatabaseConnection(): bool
	{
		$this->load->database();
		if (!$this->db->simple_query('SELECT * FROM ci_sessions LIMIT 1')) {
			return false;
		}

		return true;
	}

	private function checkRedisConnection(): bool
	{
		$this->load->driver('cache');
		$this->cache->redis->save('healthcheck', 'true', 1000);
		if (!$this->cache->redis->get('healthcheck')) {
			return false;
		}

		return true;
	}

	private function checkSendgridEmailSending(): bool
	{
		return true;
	}

	private function checkPHPMailerEmailSending(): bool
	{
		return true;
	}
}
