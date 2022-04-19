<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_profil extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_company_profil');
	}

	public function index()
	{
		$this->theme('company_profil/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_company_profil->validation()) {
			$input = [];
			foreach ($this->m_company_profil->rules() as $key => $value) {
				$input[$key] =  (isset($data[$key])?$data[$key]:null);
			}
			if ($data['id']) {
				$this->db->where('id',$data['id'])->update('company_profil',$input);
			}else{
				$this->db->insert('company_profil',$input);
			}
			$err = $this->db->error();
			if ($err['message']) {
				$resp = [
					"code" 		=> "202",
					"message"	=> $err['message']
				];
			}else{
				$resp = [
					"code" 		=> "200",
					"message"	=> "Data berhasil disimpan"
				];
			}
		}else{
			$err = implode('<br>',$this->form_validation->error_array());
			$resp = [
				"code" 		=> "201",
				"message"	=> $err
			];
		}
		$resp=json_encode($resp);
		$this->session->set_flashdata("message",$resp);
		redirect('company_profil');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_company_profil->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_company_profil',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
            $obj = array($row['id_key'],$no);
            foreach ($fields as $key => $value) {
            	if (is_array($value)) {
            		if (isset($value['custom'])){
            			$obj[] = call_user_func($value['custom'],$row[$key]);
            		}else{
            			$obj[] = $row[$key];
            		}
            	}else{
            		$obj[] = $row[$value];
            	}
            }
            $obj[] = create_btnAction(["update","delete"],$row['id_key']);
            $records["aaData"][] = $obj;
            $no++;
        }
        $data = array_merge($data,$records);
        unset($data['dataku']);
        echo json_encode($data);
	}

	public function find_one($id)
	{
		$data = $this->db->where('id',$id)->get("company_profil")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('id',$id)->delete("company_profil");
		$resp = array();
		if ($this->db->affected_rows()) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$err = $this->db->error();
			$resp['code'] = '201';
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

	public function delete_multi()
	{
		$resp = array();
		foreach ($this->input->post('data') as $key => $value) {
			$this->db->where('id',$value)->delete("company_profil");
			$err = $this->db->error();
			if ($err['message']) {
				$resp['message'] .= $err['message']."\n";
			}
		}
		if (empty($resp['message'])) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$resp['code'] = '201';
		}
		echo json_encode($resp);
	}

	public function show_form()
	{
		$data['model'] = $this->m_company_profil->rules();
		$this->load->view("company_profil/form",$data);
	}
}
