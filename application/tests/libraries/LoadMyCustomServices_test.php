<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

class LoadMyCustomServices_test extends TestCase
{
	private LoadMyCustomServices $mock;

	protected function setUp(): void
	{
		$this->mock = new LoadMyCustomServices();
	}

	public function test_all_custom_services_are_loaded(): void
	{
		$customFooService = new MyCustomFooService();

		$this->assertInstanceOf(MyCustomFooService::class, $customFooService);
		$this->assertNotNull($customFooService);
	}
}
