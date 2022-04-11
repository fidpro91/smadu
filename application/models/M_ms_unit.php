<?php

class M_ms_unit extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",unit_id as id_key  from ms_unit where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",unit_id as id_key  from ms_unit where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"unit_id",
				"unit_code"=>["label"=>"Kode"],
				"unit_name"=>["label"=>"Nama Unit"],
				//"pj_unit",
				"unit_active"=> [
					"label" => "Status",
					"custom" => function ($a) {
						if ($a == 't') {
							$condition = ["class" => "label-primary", "text" => "Aktif"];
						} else {
							$condition = ["class" => "label-danger", "text" => "Non Aktif"];
						}
						return label_status($condition);
					}
				],
				//"unit_type"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
										"unit_code" => "trim",
					"unit_name" => "trim|required",
					"pj_unit" => "trim|integer",
					"unit_active" => "trim",
					"unit_type" => "trim|integer",

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

	public function get_ms_unit($where=null)
	{
		return $this->db->get_where("ms_unit",$where)->result();
	}
	public function get_unit()
	{
		return $this->db->get_where("ms_unit")->result();
	}
	public function find_one($where)
	{
		return $this->db->get_where("ms_unit",$where)->row();
	}
}