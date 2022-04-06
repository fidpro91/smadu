<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_siswa extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker();
		$this->datascript->lib_select2();
		$this->load->model('m_ms_siswa');
	}

	public function index()
	{
		$this->theme('ms_siswa/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_ms_siswa->validation()) {
			$input = [];
			foreach ($this->m_ms_siswa->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($_FILES['photo']['name']) {
				$input['photo'] = $this->upload_data('photo', 'photo_' . $data['st_name']);
			}
			if ($data['st_id']) {
				$this->db->where('st_id',$data['st_id'])->update('ms_siswa',$input);
			}else{
				$this->db->insert('ms_siswa',$input);
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
		redirect('ms_siswa');

	}

	public function upload_data($file, $nama)
	{
		$config['upload_path'] = './assets/uploads/foto_siswa/';
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
		$fields = $this->m_ms_siswa->get_column();
		$filter = [];
		if ($attr['tahun'] != '') {
			$filter = array_merge($filter, ["st_th_masuk" => $attr['tahun']]);
		} 
		if ($attr['jk'] != ' ' ) {
			$filter = array_merge($filter, ["st_sex" => $attr['jk']]);
		} 
		$data 	= $this->datatable->get_data($fields,$filter,'m_ms_siswa',$attr);
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
		$data = $this->db->where('st_id',$id)->get("ms_siswa")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('st_id',$id)->delete("ms_siswa");
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
			$this->db->where('st_id',$value)->delete("ms_siswa");
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
		$data['model'] = $this->m_ms_siswa->rules();
		$this->load->view("ms_siswa/form",$data);
	}
}
