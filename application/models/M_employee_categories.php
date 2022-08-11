<?php

class M_employee_categories extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",empcat_id as id_key  from employee_categories where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",empcat_id as id_key  from employee_categories where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"empcat_code"=>["label"=>"Kode Kategori"],
				"empcat_name"=>["label"=>"Kategori"],
				"empcat_active"=>["label"=>"Status",
				"custom" => function ($a) {
					if ($a == 't') {
						$condition = ["class" => "label-info", "text" => "Aktif"];
					} else {
						$condition = ["class" => "label-succses", "text" => "Non Aktif"];
					}
					return label_status($condition);
				}
			],
				//"empcat_id"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"empcat_code" => "trim|required",
					"empcat_name" => "trim|required",
					"empcat_active" => "trim|required",

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

	public function get_employee_categories()
	{
		return $this->db->get_where("employee_categories")->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("employee_categories",$where)->row();
	}
}