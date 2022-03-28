<?php

class M_ms_category_unit extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",catunit_id as id_key  from ms_category_unit where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",catunit_id as id_key  from ms_category_unit where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"nama"=>["label"=>"KATEGORI"],				
				"no_sk"=>["label"=>"No SK"],
				//"tanggal_sk",
				"status_akreditasi"=>["label"=>"Akreditasi"],
				//"tanggal_akreditasi",
				//"no_akreditasi",
				"status"=>["label"=>"Status",
									"custom" => function ($a) {
						if ($a == 't') {
						$condition = ["class" => "label-primary", "text" => "Aktif"];
					} else {
						$condition = ["class" => "label-danger", "text" => "Non Aktif"];
					}
					return label_status($condition);
				}],
				//"catunit_id",
				//"dekan"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"nama" => "trim|required",
					"status" => "trim",
					"no_sk" => "trim",
					"tanggal_sk" => "trim",
					"status_akreditasi" => "trim",
					"tanggal_akreditasi" => "trim",
					"no_akreditasi" => "trim",
					"dekan" => "trim|integer",

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

	public function get_ms_category_unit($where)
	{
		return $this->db->get_where("ms_category_unit",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_category_unit",$where)->row();
	}
}