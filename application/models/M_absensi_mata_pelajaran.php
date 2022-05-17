<?php

class M_absensi_mata_pelajaran extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from absensi_mata_pelajaran ap
				join schedule_mp sm on ap.schedule_id = sm.schedule_id
				join ms_mata_pelajaran mp on sm.mp_id = mp.id_mp
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from absensi_mata_pelajaran ap
				join schedule_mp sm on ap.schedule_id = sm.schedule_id
				join ms_mata_pelajaran mp on sm.mp_id = mp.id_mp
				$sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"absen_date"=>[
					"label" => "tanggal"
				],
				"day"=>[
					"custom" => function($a){
						return show_hari($a);
					}
				],
				"mata_pelajaran",
				"check_in_at"=>[
					"label"=>"Masuk"
				],
				"check_out_at"=>[
					"label"=>"Keluar"
				],
				"absen_type"=>[
					"custom" => function($a){
						return get_absen($a);
					}
				],
				"late_duration_checkin",
				"late_duration_checkout",
				"is_verified"=>[
					"label"	=> "status",
					"custom" => function($a){
						if ($a=='t') {
							$label="<span class=\"label label-success\">Terkonfirmasi</span>";
						}else{
							$label="<span class=\"label label-warning\">Belum Dikonfirmasi</span>";
						}
						return $label;
					}
				],
			];
		return $col;
	}

	public function rules()
	{
		$data = [
										"schedule_id" => "trim|integer",
					"check_in_at" => "trim|required",
					"check_out_at" => "trim",
					"absen_type" => "trim|required",
					"is_verified" => "trim",
					"verified_by" => "trim|integer",
					"verified_at" => "trim",
					"absen_date" => "trim",
					"late_duration_checkin" => "trim",
					"late_duration_checkout" => "trim",

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

	public function get_absensi_mata_pelajaran($where)
	{
		return $this->db->get_where("absensi_mata_pelajaran",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("absensi_mata_pelajaran",$where)->row();
	}

	public function get_schedule_auto($where="",$select = "",$limit = "")
	{
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		if (is_array($where)) {
			$data =$this->db->get_where("ms_mata_pelajaran",$where)->result();
		}else{
			$data = $this->db->where($where,null)
							 ->join("ms_mata_pelajaran","schedule_mp.mp_id = ms_mata_pelajaran.id_mp",'left')
							 ->get("schedule_mp")
							 ->result();
		}
		return $data;
	}
}