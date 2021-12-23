<?php

declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

final class HomeController extends MY_Controller
{
	public function index(): void
	{
		$this->load->view('home');
	}

	protected function middleware(): array
	{
		// The first part should be the Middleware name : And following this format you can provide N arguments to middleware separating with :
		return ['Foo:firstArgument:secondArgument:thirdArgument'];
	}

	public function foo(): void
	{
		echo "<h2>This is the Foo EndPoint</h2>";
	}
}
