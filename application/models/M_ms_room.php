<?php

class M_ms_room extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",room_id as id_key  from ms_room where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",room_id as id_key  from ms_room where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"room_id",
				"room_code",
				"kelas",
				"room_name"=>["label"=>"Nama Kelas"],
				"capacity"=>["label"=>"Quota"],
				"room_active"=>["label"=>"status",
				"custom" => function ($a) {
					if ($a == 't') {
						$condition = ["class" => "label-success", "text" => "Aktif"];
					} else {
						$condition = ["class" => "label-danger", "text" => "Non Aktif"];
					}
					return label_status($condition);
				}]

			
				];
		return $col;
	}

	public function rules()
	{
		$data = [
										"room_code" => "trim|required",
					"kelas" => "trim|integer|required",
					"room_name" => "trim|required",
					"capacity" => "trim|integer",
					"room_active" => "trim",

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

	public function get_ms_room($where)
	{
		return $this->db->get_where("ms_room",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_room",$where)->row();
	}
}