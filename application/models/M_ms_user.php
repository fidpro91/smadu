<?php

class M_ms_user extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",user_id as id_key  from ms_user u
				left join ms_group mg on u.user_group = mg.group_id where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",user_id as id_key  from ms_user u
				left join ms_group mg on u.user_group = mg.group_id
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"user_name",
				//"user_password",
				"user_salt_encrypt",
				//"user_id",
				"user_status"=>["label"=>"status",
				"custom" => function ($a) {
					if ($a == 't') {
						$condition = ["class" => "label-primary", "text" => "Aktif"];
					} else {
						$condition = ["class" => "label-danger", "text" => "Non Aktif"];
					}
					return label_status($condition);
				}],
				"person_name"=>["label"=>"nama"],
				"group_name"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"user_name" => "trim|required",
					"user_password" => "trim|required",
					"user_salt_encrypt" => "trim",
					"user_status" => "trim|required",
					"person_name" => "trim",
					"emp_id" => "trim",
					"user_group" => "trim|integer|required",

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

	public function get_ms_user($where)
	{
		return $this->db->get_where("ms_user",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_user",$where)->row();
	}
}