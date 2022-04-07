<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Generator {

	public function __construct()
	{
		
		parent::__construct();
		$this->datascript->lib_datepicker();
		$this->datascript->lib_select2();
		$this->load->model('m_employee');
		
	}

	public function index()
	{
		
		$this->theme('employee/index');
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_employee->validation()) {
			$input = [];
			foreach ($this->m_employee->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($_FILES['emp_photo']['name']) {
				$input['emp_photo'] = $this->upload_data('emp_photo', 'photo_' . $data['emp_name']);
			}
			if ($data['emp_id']) {
				$this->db->where('emp_id',$data['emp_id'])->update('employee',$input);
			}else{
				$this->db->insert('employee',$input);
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
		redirect('employee');

	}

	public function upload_data($file, $nama)
	{
		$config['upload_path'] = './assets/uploads/foto_pegawai/';
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

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_employee->get_column();
		$filter=[];
		if($attr['empcat_id']>0){
			$filter = ["empcat_id" => $attr['empcat_id']];
		}	
		if ($attr['jb'] ) {
			$filter = array_merge($filter, ["x.position_id" => $attr['jb']]);
		}
		$data 	= $this->datatable->get_data($fields,$filter,'m_employee',$attr);
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
		$data = $this->db->where('emp_id',$id)->get("employee")->row();

		echo json_encode($data);
	}

	public function get_employee()
	{
		$term = $this->input->get('term');
		$limit = 25;
		$where = " lower(emp_name) like lower('%$term%')";
		$select = "*,concat(emp_no,'-',emp_name) as label";
		// $where .= " AND class_id = '$class_id'";
		echo json_encode($this->m_employee->get_employee2($where,$select,$limit));
	}

	public function delete_row($id)
	{
		$this->db->where('emp_id',$id)->delete("employee");
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
			$this->db->where('emp_id',$value)->delete("employee");
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

	public function get_region($id)
	{
		$this->load->model("m_ms_region");
		$resp = "";
		foreach ($this->m_ms_region->get_ms_region(["reg_parent" => $id]) as $key => $value) {
			$resp .= "<option value=\"$value->reg_code\">$value->reg_name</option>\n";
		}
		echo $resp;
	}

	public function show_form()
	{
		$data['model'] = $this->m_employee->rules();
		$this->load->view("employee/form",$data);
	}
}
