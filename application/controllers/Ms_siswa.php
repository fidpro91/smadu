<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
class Ms_siswa extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker();
		$this->datascript->lib_select2();
		
		$this->load->model('m_ms_siswa');
		$this->finger = $this->load->database('finger', TRUE);
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
				$input[$key] = (isset($data[$key])?$data[$key]:null);
			}
			if ($_FILES['photo']['name']) {
				$input['photo'] = $this->upload_data('photo', 'photo_' . $data['st_name']);
			}
			$input['user_id'] = $this->session->user_id;

			if ($data['st_id']) {
				$this->db->where('st_id',$data['st_id'])->update('ms_siswa',$input);
				$insertFinger = [
					"pegawai_nama" 	  => $input['st_name'],
					"pegawai_alias"   => $input['st_name'],
					"tempat_lahir"    => $input['st_born'],
					"tgl_lahir"		  => $input['st_phone'],
					"tgl_mulai_kerja" => date('Y-m-d'),
					"tgl_masuk_pertama"	=> date('Y-m-d'),
					"gender"		  => ($input['st_sex']=='L'?1:2)
				];
				if (!empty($input["finger_id"])) {
					$this->finger->where("pegawai_id",$input["finger_id"])
								 ->update("pegawai",$insertFinger);
				}
			}else{
				$pin=$this->finger->select_max('pegawai_pin')
							 ->get('pegawai')->row('pegawai_pin');
				$pin = $pin+1;
				$insertFinger = [
					"pegawai_nama" 	  => $input['st_name'],
					"pegawai_alias"   => $input['st_name'],
					"tempat_lahir"    => $input['st_born'],
					"tgl_lahir"		  => $input['st_phone'],
					"tgl_mulai_kerja" => date('Y-m-d'),
					"tgl_masuk_pertama"	=> date('Y-m-d'),
					"pegawai_pin"			 => $pin,
					"gender"		  => ($input['st_sex']=='L'?1:2)
				];
				$this->finger->insert('pegawai',$insertFinger);
				$input['finger_id'] = $pin;
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
			$err = implode('<br>',$this->form_validation->error_array());
			$resp = [
				"code" 		=> "201",
				"message"	=> $err
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
		if (!empty($attr['kelas'])) {
			$filter = array_merge($filter, ["last_kelas" => $attr['kelas']]);
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

	public function get_siswa()
	{
		$term = $this->input->get('term');
		$limit = 25;
		$where = " lower(st_name) like lower('%$term%')";
		$select = "*,concat(st_nim,'-',st_name) as label";
		// $where .= " AND class_id = '$class_id'";
		echo json_encode($this->m_ms_siswa->get_ms_siswa2($where,$select,$limit));
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

	public function import_excel($value='')
	{
		$arr_file = explode('.', $_FILES['siswa_import']['name']);
	    $extension = end($arr_file);
	 
	    if('csv' == $extension) {
	        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
	    } else {
	        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	    }

		
	 
	    $spreadsheet = $reader->load($_FILES['siswa_import']['tmp_name']);
	     
	    $sheetData = $spreadsheet->getActiveSheet()->toArray();
	    $sukses=$gagal=0;
	    $data=[];
	    $dataGagal="";
	    $this->load->model("m_ms_siswa");
		$resp = array();
	    foreach ($sheetData as $key => $value) {
	    	if ($key>0) {
	    		$row = [
	    					"st_nis" 		=> $value[1],
							"st_name" 	=> $value[2],
							"st_sex" 		=> $value[3],							
							"st_active" 	=> "t",
							"st_birthdate" 	=> date('Y-m-d',strtotime($value[4])),
							"st_address" 		=> $value[5],
	    				];

	    			$data[$key] = $row;
	    			$sukses++;	
	    	}
	    }
	    
	    if ($sukses>0) {
	    	$this->db->insert_batch('ms_siswa',$data); 
	    }
		if (empty($resp)) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil di upload';
		}else{
			$resp['code'] = '201';
		}
	  
	   //	
	   $resp= json_encode($resp);
	   $this->session->set_flashdata("message",$resp);
	   redirect('ms_siswa');
	}

	public function show_form()
	{
		$data['model'] = $this->m_ms_siswa->rules();
		$this->load->view("ms_siswa/form",$data);
	}
}
