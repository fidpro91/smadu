<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_profil extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker();
		$this->load->model('m_company_profil');

	}

	public function index()	
	{
		$data['smadu'] = $this->m_company_profil->find_one([]); 
		$this->theme('company_profil/index',$data); 
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_company_profil->validation()) {
			$input = [];
			foreach ($this->m_company_profil->rules() as $key => $value) {
				$input[$key] =  (isset($data[$key])?$data[$key]:null);
			}
			if ($_FILES['logo1']['name']) {
				$input['logo1'] = $this->upload_data('logo1', 'logo_du' . $data['logo1']); 
			}
			if ($data['kode_instansi']) {
				$this->db->where('kode_instansi',$data['kode_instansi'])->update('company_profil',$input);
			}else{
				$this->db->insert('company_profil',$input);
			}
			$err = $this->db->error();
			if ($err['message']) {
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$err['message'].'</div>');
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil disimpan</div>');
			}
		}else{
			$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>','</div>'));
		}
		redirect('company_profil');

	}

	public function upload_data($file, $nama)
	{
		$config['upload_path'] = 'assets/images/icon/'; 
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['file_name'] = $nama;
		$config['overwrite'] = true;
		$config['max_size'] = 1024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload($file)) {
			return ltrim($config["upload_path"].$this->upload->data("file_name"),'./');
		} else {
			return $this->upload->display_errors();
		}
	}

	public function find_one($id)
	{
		$data = $this->db->where('kode_instansi',$id)->get("company_profil")->row();

		echo json_encode($data);
	}

	public function show_form()
	{
		$data['model'] = $this->m_company_profil->rules();
		$this->load->view("company_profil/form",$data); 
	}
}
