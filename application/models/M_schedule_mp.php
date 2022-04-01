<?php

class M_schedule_mp extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",schedule_id as id_key from schedule_mp sm
				join ms_mata_pelajaran mp on sm.mp_id = mp.id_mp
				join ms_unit mu on mu.unit_id = sm.class_id
				join employee e on e.emp_id = sm.guru_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",schedule_id as id_key from schedule_mp sm
				join ms_mata_pelajaran mp on sm.mp_id = mp.id_mp
				join ms_unit mu on mu.unit_id = sm.class_id
				join employee e on e.emp_id = sm.guru_id
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"day"=>[
					"custom" => function($a){
						return show_hari($a);
					}
				],
				"unit_name",
				"semester_id"=>[
					"custom" => function($a){
						return get_semester($a);
					}
				],
				"mata_pelajaran",
				"emp_name",
				"start_time",
				"finish_time",
				"tahun_pelajaran",
				"is_active"=>[
					"initial" => "sm"
				]
			];
		return $col;
	}

	public function get_column_multi()
	{
		$col = [
			"day",
			"mp_id",
			"guru_id",
			"start_time",
			"finish_time",
		];
		return $col;
	}

	public function rules()
	{
		$data = [
					"mp_id" => "trim|integer|required",
					"guru_id" => "trim|integer|required",
					"day" => "trim|integer|required",
					"start_time" => "trim",
					"class_id" => "trim|integer|required",
					"set_by" => "trim|integer",
					"finish_time" => "trim",
					"tahun_pelajaran" => "trim|required",
					"semester_id" => "trim|required",
					"is_active" => "trim",
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

	public function get_schedule_mp($where)
	{
		return $this->db->get_where("schedule_mp",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("schedule_mp",$where)->row();
	}

	public function get_dosen($select = "", $where = array())
	{
		if ($select) {
			$this->db->select($select);
		}
		return $this->db->get_where("employee", $where)->result();
	}
}