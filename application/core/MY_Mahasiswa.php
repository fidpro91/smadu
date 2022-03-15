<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Mahasiswa extends CI_Controller
{
	protected $userData = "";
	protected $setting = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->model('builder/m_builder');
		$this->load->model("get_db");
		$this->load->library('datascript');
		/* if (empty($this->session->person_name)) {
			redirect('login');
		} */
	}

	public function theme($url,$data = array(),$title='')
	{

		$title = str_replace('_',' ',$title);
		$header['title'] = 'SIAKAD Application | '.$title;
		$header['contentHeader'] = $title;
		$header["menu"] = $this->get_db->get_menu_mahasiswa();
		$this->load->view('template/mahasiswa/header',$header);
		$this->load->view( $url, $data);
		$this->load->view('template/mahasiswa/footer');
	}
}