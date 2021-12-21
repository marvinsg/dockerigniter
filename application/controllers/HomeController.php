<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class HomeController extends MY_Controller
{
	public function index()
	{
		$this->load->view('home');
	}

	protected function middleware()
	{
		// The first part should be the Middleware name : And following this format you can provide N arguments to middleware separating with :
		return ['Foo:firstArgument:secondArgument:thirdArgument'];
	}

	public function foo()
	{
		echo "<h2>This is the Foo EndPoint</h2>";
	}
}
