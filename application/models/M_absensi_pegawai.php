<?php

class M_absensi_pegawai extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key  from absensi_pegawai where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key  from absensi_pegawai where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"absen_id",
				"emp_absen_code",
				"absen_date",
				"check_in",
				"check_out",
				"late_duration",
				"absen_type",
				"user_created",
				"created_at"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"emp_absen_code" => "trim|required",
					"absen_date" => "trim|required",
					"check_in" => "trim|required",
					"check_out" => "trim|required",
					"late_duration" => "trim|numeric",
					"absen_type" => "trim|required",
					"user_created" => "trim|integer",
					
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

	public function get_absensi_pegawai($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->row();
	}
}