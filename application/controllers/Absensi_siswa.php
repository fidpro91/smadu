<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_siswa extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_inputmask()
						 ->lib_datepicker();
		$this->load->model('m_absensi_siswa');
	}

	public function index()
	{
		$this->theme('absensi_siswa/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_absensi_siswa->validation()) {
			$input = [];
			foreach ($this->m_absensi_siswa->rules() as $key => $value) {
				$input[$key] =  (isset($data[$key])?$data[$key]:null);
			}
			$input["user_created"] = $this->session->user_id;
			$input["verified_by"]  = $this->session->user_id;
			$input["check_in"]	   = $input["absen_date"]." ".$input["check_in"];
			$input["check_out"]	   = $input["absen_date"]." ".$input["check_out"];
			if ($input["absen_type"] == 1) {
				$jadwal = $this->db->get_where("jam_kerja_harian",[
					"hari"				=> date("w",strtotime($input["absen_date"])),
					"jadwal_untuk"		=> $this->setting->kode_jadwal_siswa
				])->row("jam_masuk");
				$jadwal = $input["absen_date"]." ".$jadwal;
				$selisih = selisih_waktu($input["check_in"],$jadwal);
				$input["late_duration_in"] = $selisih["total"];
			}
			if ($_FILES['berkas']['name']) {
				$input['berkas'] = $this->upload_data('berkas', 'ijin_' . $input['absen_code']."_".$data['absen_date']);
			}
			if ($data['absen_id']) {
				$this->db->where('absen_id',$data['absen_id'])->update('absensi_siswa',$input);
			}else{
				$this->db->insert('absensi_siswa',$input);
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
		redirect('absensi_siswa');

	}

	public function upload_data($file, $nama)
	{
		$config['upload_path'] = './assets/uploads/berkas_absen_siswa/';
		$config['allowed_types'] = 'jpg|jpeg|png|pdf';
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
		$fields = $this->m_absensi_siswa->get_column();
		$filter=[];
		if ($attr["verifikasi"]=='t') {
			$filter["is_verified"] = $attr["verifikasi"]; 
		}else{
			$filter["custom"] = "(is_verified is null or is_verified = '".$attr["verifikasi"]."')"; 
		}

		if (!empty($attr["tanggal"])) {
			$filter["absen_date"] = $attr["tanggal"]; 
		}

		if (!empty($attr["unit"])) {
			$filter["unit_id"] = $attr["unit"]; 
		}
		if ($attr["absen_type"] > 0) {
			$filter["absen_type"] = $attr["absen_type"]; 
		}
		$data 	= $this->datatable->get_data($fields,$filter,'m_absensi_siswa',$attr);
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
		$data = $this->db->where('absen_id',$id)
						 ->join("ms_siswa ms","ms.st_id = ab.siswa_id")
						 ->select("ab.*, ms.st_name,time(check_in)check_in,time(check_out)check_out")
						 ->get("absensi_siswa ab")->row();
		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('absen_id',$id)->delete("absensi_siswa");
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
			$this->db->where('absen_id',$value)->delete("absensi_siswa");
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
		$data['model'] = $this->m_absensi_siswa->rules();
		$this->load->view("absensi_siswa/form",$data);
	}

	public function verifikasi_multi()
	{
		$resp = array();
		foreach ($this->input->post('data') as $key => $value) {
			$this->db->where('absen_id',$value)->update("absensi_siswa",[
				"is_verified" 	=> "t",
				"verified_by"	=> $this->session->user_id
			]);
			$err = $this->db->error();
			if ($err['message']) {
				$resp['message'] .= $err['message']."\n";
			}
		}
		if (empty($resp['message'])) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil diverifikasi';
		}else{
			$resp['code'] = '201';
		}
		echo json_encode($resp);
	}

	public function get_scanlog()
	{
		$this->finger = $this->load->database("finger",true);
		$dataScan = $this->finger->order_by("scan_date")->get("att_log")->result();
		$this->db->trans_begin();
		$dataInsert=[];
		foreach ($dataScan as $key => $value) {
			$pin = $value->pin;
			$dataSiswa = $this->db->get_where("ms_siswa",["finger_id"=>$pin]);
			if ($dataSiswa->num_rows()>0) {
				$dataSiswa = $dataSiswa->row();
				$tglabsen = date("Y-m-d",strtotime($value->scan_date));
				$absenSiswa = array_filter($dataInsert, function ($var) use($pin,$tglabsen){
					return ($var['absen_code'] == $pin && $var['absen_date'] == $tglabsen);
				});
				$cekAbsen = $this->db->get_where("absensi_siswa",[
								"absen_code"	=> $pin,
								"absen_date"	=> $tglabsen
							])->num_rows();
				if (count($absenSiswa)==0 && $cekAbsen==0) {
					$jadwal = $this->db->get_where("jam_kerja_harian",[
						"hari"				=> date("w",strtotime($value->scan_date)),
						"jadwal_untuk"		=> $this->setting->kode_jadwal_siswa
					])->row("jam_masuk");
					$jadwal = date("Y-m-d",strtotime($value->scan_date))." ".$jadwal;
					$selisih = selisih_waktu($value->scan_date,$jadwal);
					$dataInsert[$key] = [
						"absen_code" => $pin,
						"absen_date" => date("Y-m-d",strtotime($value->scan_date)),
						"check_in"	 => $value->scan_date,
						"absen_type" => 1,
						"user_created" => $this->session->user_id,
						"siswa_id"	   => $dataSiswa->st_id,
						"late_duration_in" => $selisih["total"],
						"is_verified"  => "f"
					];
				}
			}
		}
		if (count($dataInsert) > 0) {
			$this->db->insert_batch("absensi_siswa",$dataInsert);
		}
		$resp = array();
		if ($this->db->trans_status() !== false) {
			$this->db->trans_commit();
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil direload';
		}else{
			$this->db->trans_rollback();
			$err = $this->db->error();
			$resp['code'] = '201';
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

	public function show_list()
	{
		$this->theme('presensi/index','',"List data");
	}

	public function load_record($rowno=0)
	{
		$this->load->library("pagination"); 
		// Row per page
		 $rowperpage = 5;

		 // Row position
		 if($rowno != 0){
		   $rowno = ($rowno-1) * $rowperpage;
		 }
	  
		 // All records count
		 $allcount = $this->db->count_all('absensi_siswa');
	 
		 // Get records
		 $users_record = $this->m_absensi_siswa->getData($rowno,$rowperpage);
	  
		 // Pagination Configuration
		 $config['base_url'] = base_url().'absensi_siswa/load_record';
		 $config['use_page_numbers'] = TRUE;
		 $config['total_rows'] = $allcount;
		 $config['per_page'] = $rowperpage;
		 
		 //themes
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']  = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';
		 // Initialize
		 $this->pagination->initialize($config);
	 
		 // Initialize $data Array
		 $data['pagination'] = $this->pagination->create_links();
		 $isi['data'] = $users_record;
		 $data['result'] = $this->load->view("presensi/form_data",$isi,true);
		 $data['row'] = $rowno;
	 
		 echo json_encode($data);
	}
}
