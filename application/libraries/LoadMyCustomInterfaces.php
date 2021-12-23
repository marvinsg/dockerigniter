<?php

declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed');

final class LoadMyCustomInterfaces
{
	private const INTERFACES_PATH             = FCPATH . 'application/interfaces';
	private const NEEDLES_FOR_INTERFACE_FILES = ['Interface', 'interface'];

	public function __construct()
	{
		$this->initInterfacesAutoloader();
	}

	private function initInterfacesAutoloader(): void
	{
		spl_autoload_register(static function ($classname) {
			foreach (self::NEEDLES_FOR_INTERFACE_FILES as $needleForInterfaceFile){
				if (strpos($classname, $needleForInterfaceFile) !== false) {
					require(self::INTERFACES_PATH . '/' . $classname . '.php');
				}
			}
		});
	}
}
