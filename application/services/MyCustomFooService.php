<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

final class MyCustomFooService
{
	private $CI;

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function __invoke(): void
	{
		echo "I am the custom Foo service";
	}
}
