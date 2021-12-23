<?php

declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed');

final class LoadMyCustomServices
{
	private const SERVICES_PATH              = FCPATH . 'application/services';
	private const NEEDLES_FOR_SERVICES_FILES = ['Service', 'service'];

	public function __construct()
	{
		$this->initServicesAutoloader();
	}

	private function initServicesAutoloader(): void
	{
		spl_autoload_register(static function ($classname) {
			foreach (self::NEEDLES_FOR_SERVICES_FILES as $needleForInterfaceFile){
				if (strpos($classname, $needleForInterfaceFile) !== false) {
					require(self::SERVICES_PATH . '/' . $classname . '.php');
				}
			}
		});
	}
}
