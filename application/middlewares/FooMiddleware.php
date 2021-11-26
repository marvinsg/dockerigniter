<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class FooMiddleware
{
	protected $controller;
	protected $ci;

	public function __construct($controller, $ci)
	{
		$this->controller = $controller;
		$this->ci         = $ci;
	}

	public function run(?array $arguments = null): void
	{
		// Here you can implement your middleware logic
	}
}
