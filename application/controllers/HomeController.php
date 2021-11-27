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
		return ['Foo:firstArgument'];
	}

	public function foo()
	{
		echo "<h2>This is the Foo EndPoint</h2>";
	}
}
