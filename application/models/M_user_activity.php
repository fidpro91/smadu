<?php

class M_user_activity extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from user_activity ua
				join ms_user mu on ua.user_id=mu.user_id 
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from user_activity ua
				join ms_user mu on ua.user_id=mu.user_id where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"user_id" => [
					"initial" => "ua"
				],
				"user_name",
				"person_name",
				"act_date",
				"keterangan",
				"act_data"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
										"user_id" => "trim|integer|required",
										"keterangan" => "trim",
					"act_data" => "trim",

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

	public function get_user_activity($where)
	{
		return $this->db->get_where("user_activity",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("user_activity",$where)->row();
	}
}