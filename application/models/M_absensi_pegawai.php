<?php

class M_absensi_pegawai extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key from absensi_pegawai ap
				join employee e on ap.emp_id = e.emp_id
				join ms_unit u on ap.kode_ruangan = u.code_barcode	
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key from absensi_pegawai ap
				join employee e on ap.emp_id = e.emp_id 
				join ms_unit u on ap.kode_ruangan = u.code_barcode	
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"absen_date",
				"emp_no",
				"emp_name",
				"check_in"=>[
					"custom" => function($a){
						$jam = explode(" ",$a);
						return $jam[1];
					}
				],
				"absen_type"=>[
					"custom" => function($a){
						return get_absen_pegawai($a);
					}
				],
				"late_duration_in"=>[
					"label" 	=> "keterangan",
					"custom"	=> function($a){
						if ($a>0) {
							$txt = "Lebih awal $a Menit";
						}elseif($a==0){
							$txt = "";
						}else{
							$txt = "Lebih lambat ".abs($a)." Menit";
						}
						return $txt;
					}
				],
				"is_verified"=>[
					"label" => "Status",
					"custom" => function ($a) {
						if ($a == 't') {
							$condition = ["class" => "label-success", "text" => "Terverifikasi"];
						} else {
							$condition = ["class" => "label-warning", "text" => "Belum Diverifikasi"];
						}
						return label_status($condition);
					}
				],
				"verified_by"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"emp_absen_code" => "trim",
					"absen_date" => "trim|required",
					"check_in" => "trim",
					"check_out" => "trim",
					"late_duration_in" => "trim",
					"late_duration_ot" => "trim",
					"is_verified" => "trim",
					"absen_type" => "trim|required",
					"user_created" => "trim|integer",
					"emp_id" => "trim|integer|required",
				];
		return $data;
	}

	public function validation()
	{
		foreach ($this->rules() as $key => $value) {
			$this->form_validation->set_rules($key,$key,$value);
		}

		return $this->form_validation->run();
	}

	public function get_absensi_pegawai($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->row();
	}
}