<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_mata_pelajaran extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_select2();
		$this->load->model('m_ms_mata_pelajaran');
	}

	public function index()
	{
		$this->theme('ms_mata_pelajaran/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_ms_mata_pelajaran->validation()) {
			$input = [];
			foreach ($this->m_ms_mata_pelajaran->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($data['id_mp']) {
				$this->db->where('id_mp',$data['id_mp'])->update('ms_mata_pelajaran',$input);
			}else{
				$this->db->insert('ms_mata_pelajaran',$input);
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
		redirect('ms_mata_pelajaran');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_ms_mata_pelajaran->get_column();
		$data 	= $this->datatable->get_data($fields,$filter = array(),'m_ms_mata_pelajaran',$attr);
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
		$data = $this->db->where('id_mp',$id)->get("ms_mata_pelajaran")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('id_mp',$id)->delete("ms_mata_pelajaran");
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
			$this->db->where('id_mp',$value)->delete("ms_mata_pelajaran");
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
		$data['model'] = $this->m_ms_mata_pelajaran->rules();
		$this->load->view("ms_mata_pelajaran/form",$data);
	}

	
}
