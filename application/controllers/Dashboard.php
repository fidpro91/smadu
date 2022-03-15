<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->theme('dashboard/dashboard','',get_class($this));
	}
}
