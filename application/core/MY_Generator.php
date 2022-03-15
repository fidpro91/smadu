<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Generator extends CI_Controller
{
	protected $userData = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->model('builder/m_builder');
		$this->load->model("get_db");
		$this->load->library('datascript');
		/* if (empty($this->session->person_name)) {
			redirect('login');
		} *//* else{
			$uriku = $this->uri->segment(1);
			if ($this->get_db->validation_access($this->session->group_user,$uriku)==0) {
				$this->output->set_status_header('404'); 
			};
		} */

	}

	public function theme($url,$data = array(),$title='')
	{

		$header['title'] = 'SIDU | '.$title;
		$header['pagename'] = $title;
		$this->load->view('template/header',$header);
		$sidebar["menu"] = $this->get_db->get_menu();
		$this->load->view('template/sidebar',$sidebar);
		$this->load->view('template/header2',$header);
		$this->load->view( $url, $data);
		$this->load->view('template/footer');
	}
}