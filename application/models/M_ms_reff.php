<?php

class M_ms_reff extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",reff_id as id_key  from ms_reff rf
				join  ms_reff_cat rc on rf.refcat_id = rc.refcat_id where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",reff_id as id_key  from ms_reff rf
				join  ms_reff_cat rc on rf.refcat_id = rc.refcat_id where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"reff_id",
				"reff_code",
				"reff_name",
				"reff_active"=> [
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
			
				"refcat_name"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"reff_code" => "trim|required",
					"reff_name" => "trim|required",
					"reff_active" => "trim|required",
					"refcat_id" => "trim|integer|required",

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

	public function get_ms_reff($where)
	{
		return $this->db->get_where("ms_reff",$where)->result();
	}


	public function find_one($where)
	{
		return $this->db->get_where("ms_reff",$where)->row();
	}
}