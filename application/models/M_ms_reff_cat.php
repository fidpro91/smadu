<?php

class M_ms_reff_cat extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",refcat_id as id_key  from ms_reff_cat where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",refcat_id as id_key  from ms_reff_cat where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"refcat_id",
				"refcat_name",
				"refcat_active"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"refcat_name" => "trim|required",
					"refcat_active" => "trim|required",

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

	public function get_ms_reff_cat($where=null)
	{
		return $this->db->get_where("ms_reff_cat",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_reff_cat",$where)->row();
	}
}