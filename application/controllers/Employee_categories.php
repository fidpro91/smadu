<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_categories extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_employee_categories');
	}

	public function index()
	{
		$this->theme('employee_categories/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_employee_categories->validation()) {
			$input = [];
			foreach ($this->m_employee_categories->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($data['empcat_id']) {
				$this->db->where('empcat_id',$data['empcat_id'])->update('employee_categories',$input);
			}else{
				$this->db->insert('employee_categories',$input);
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
			$resp = [
				"code" 		=> "201",
				"message"	=> "error validasi"
			];
		}
		$resp=json_encode($resp);
		$this->session->set_flashdata("message",$resp);
		redirect('employee_categories');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_employee_categories->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_employee_categories',$attr);
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
		$data = $this->db->where('empcat_id',$id)->get("employee_categories")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('empcat_id',$id)->delete("employee_categories");
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
			$this->db->where('empcat_id',$value)->delete("employee_categories");
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
		$data['model'] = $this->m_employee_categories->rules();
		$this->load->view("employee_categories/form",$data);
	}
}
