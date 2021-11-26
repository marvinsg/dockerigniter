<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller
{
	public function index()
	{
		$this->load->view('home');
	}

	public function foo()
	{
		echo "<h2>This is the Foo EndPoint</h2>";
	}
}
