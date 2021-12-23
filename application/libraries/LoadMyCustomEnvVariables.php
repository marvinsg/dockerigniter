<?php

declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed');

use Dotenv\Dotenv;

defined('BASEPATH') or exit('No direct script access allowed');

final class LoadMyCustomEnvVariables
{
	public function __construct()
	{
		$this->loadEnv();
	}

	private function loadEnv(): void
	{
		$dotenv = Dotenv::createImmutable(FCPATH);
		$dotenv->load();
	}
}
