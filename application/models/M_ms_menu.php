<?php

class M_ms_menu extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",menu_id as id_key  from ms_menu where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",menu_id as id_key  from ms_menu where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"menu_id",
				"menu_code",
				"menu_name",
				"menu_url",
				"menu_parent_id",
				"menu_status",
				"menu_icon",
				"slug"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"menu_code" => "trim|required",
					"menu_name" => "trim|required",
					"menu_url" => "trim",
					"menu_parent_id" => "trim|integer",
					"menu_status" => "trim",
					"menu_icon" => "trim",
					"slug" => "trim",

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

	public function get_ms_menu($where)
	{
		return $this->db->get_where("ms_menu",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_menu",$where)->row();
	}
}