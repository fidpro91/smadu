<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_pegawai extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker()
						 ->lib_inputmask();
		$this->load->model('m_absensi_pegawai');
	}

	public function index()
	{
		$this->theme('absensi_pegawai/index','',get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_absensi_pegawai->validation()) {
			$input = [];
			foreach ($this->m_absensi_pegawai->rules() as $key => $value) {
				$input[$key] =  (isset($data[$key])?$data[$key]:null);
			}
			$input["user_created"] = $this->session->user_id;
			$input["verified_by"]  = $this->session->user_id;
			$input["check_in"]	   = $input["absen_date"]." ".$input["check_in"];
			$input["check_out"]	   = $input["absen_date"]." ".$input["check_out"];
			if ($input["absen_type"] == 1) {
				$jadwal = $this->db->get_where("jam_kerja_harian",[
					"hari"				=> date("w",strtotime($input["absen_date"])),
					"jadwal_untuk"		=> $this->setting->kode_jadwal_pegawai
				])->row("jam_masuk");
				$jadwal = $input["absen_date"]." ".$jadwal;
				$selisih = selisih_waktu($input["check_in"],$jadwal);
				$input["late_duration_in"] = $selisih["total"];
			}
			if ($_FILES['berkas']['name']) {
				$input['berkas'] = $this->upload_data('berkas', 'ijin_' . $input['emp_id']."_".$data['absen_date']);
			}
			if ($data['absen_id']) {
				$this->db->where('absen_id',$data['absen_id'])->update('absensi_pegawai',$input);
			}else{
				$this->db->insert('absensi_pegawai',$input);
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
		redirect('absensi_pegawai');

	}

	public function upload_data($file, $nama)
	{
		$config['upload_path'] = './assets/uploads/berkas_absen_pegawai/';
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
		$fields = $this->m_absensi_pegawai->get_column();
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
		$data 	= $this->datatable->get_data($fields,$filter,'m_absensi_pegawai',$attr);
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
						 ->join("employee e","e.emp_id=a.emp_id")
						 ->get("absensi_pegawai a")->row();
		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('absen_id',$id)->delete("absensi_pegawai");
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
			$this->db->where('absen_id',$value)->delete("absensi_pegawai");
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

	public function verifikasi_multi()
	{
		$resp = array();
		foreach ($this->input->post('data') as $key => $value) {
			$this->db->where('absen_id',$value)->update("absensi_pegawai",[
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

	public function show_form()
	{
		$data['model'] = $this->m_absensi_pegawai->rules();
		$this->load->view("absensi_pegawai/form",$data);
	}
}
