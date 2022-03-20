<?php

class M_employee extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",emp_id as id_key  from employee where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",emp_id as id_key  from employee where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"emp_id",
				"emp_no",
				"emp_noktp",
				"emp_nokk",
				"emp_name",
				"emp_sex",
				"emp_birthdate",
				"emp_status",
				"emp_couple",
				"emp_phone",
				"emp_address",
				"emp_resident",
				"emp_district",
				"emp_city",
				"emp_prov",
				"emp_npwp",
				"tahun_masuk",
				"unit_id",
				"position_id",
				"agama",
				"pendidikan",
				"emp_active",
				"emp_born",
				"emp_mail",
				"emp_type",
				"absen_code",
				"emp_photo",
				"tanggal_keluar",
				"alamat_domisili"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"emp_no" => "trim",
					"emp_noktp" => "trim",
					"emp_nokk" => "trim",
					"emp_name" => "trim|required",
					"emp_sex" => "trim|required",
					"emp_birthdate" => "trim",
					"emp_status" => "trim",
					"emp_couple" => "trim",
					"emp_phone" => "trim",
					"emp_address" => "trim",
					"emp_resident" => "trim",
					"emp_district" => "trim",
					"emp_city" => "trim",
					"emp_prov" => "trim",
					"emp_npwp" => "trim",
					"tahun_masuk" => "trim",
					"unit_id" => "trim|integer",
					"position_id" => "trim|integer",
					"agama" => "trim",
					"pendidikan" => "trim",
					"emp_active" => "trim",
					"emp_born" => "trim",
					"emp_mail" => "trim",
					"emp_type" => "trim",
					"absen_code" => "trim",
					"emp_photo" => "trim",
					"tanggal_keluar" => "trim",
					"alamat_domisili" => "trim",

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

	public function get_employee($where)
	{
		return $this->db->get_where("employee",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("employee",$where)->row();
	}
}