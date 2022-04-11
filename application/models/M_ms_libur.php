<?php

class M_ms_libur extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_libur as id_key from ms_libur ml
				join ms_reff mr on ml.reff_id = mr.reff_id 
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_libur as id_key from ms_libur ml
				join ms_reff mr on ml.reff_id = mr.reff_id  
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"reff_name"=>[
					"label" => "Libur"
				],
				"perulangan_libur"=>[
					"label" => "jenis libur",
					"custom" => function($a){
						if ($a == '1') {
							$condition = ["class" => "label-info", "text" => "Harian"];
						} else {
							$condition = ["class" => "label-warning", "text" => "Mingguan"];
						}
						return label_status($condition);
					}
				],
				"hari"=>[
					"custom" => function($a){
						if ($a) {
							return show_hari($a);
						}else{
							return null;
						}
					}
				],
				"tanggal",
				"libur_tahun",
				"keterangan"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"reff_id" => "trim|integer|required",
					"hari" => "trim|integer",
					"tanggal" => "trim",
					"libur_tahun" => "trim|required",
					"keterangan" => "trim",
					"created_by" => "trim|integer",
					"created_at" => "trim",
					"libur_type" => "trim",
					"perulangan_libur" => "trim|integer",

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

	public function get_ms_libur($where)
	{
		return $this->db->get_where("ms_libur",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_libur",$where)->row();
	}
}