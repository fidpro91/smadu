<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data["siswa"] = $this->db->get_where("ms_siswa",[
			"st_active" => "t"
		])->num_rows();
		$data["pegawai"] = $this->db->get_where("employee",[
			"emp_active" => "t"
		])->num_rows();
		$this->theme('dashboard/dashboard',$data,get_class($this));
	}
}
