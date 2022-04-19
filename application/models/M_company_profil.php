<?php

class M_company_profil extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from company_profil where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from company_profil where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"id",
				"kode_instansi",
				"nama_instansi",
				"alamat_instansi",
				"no_telp",
				"email",
				"website",
				"kepala_instansi",
				"no_sk",
				"tanggal_berdiri",
				"status_akreditasi",
				"tanggal_akreditasi",
				"logo1",
				"logo2",
				"logo3"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"id" => "trim|integer|required",
					"kode_instansi" => "trim|required",
					"nama_instansi" => "trim|required",
					"alamat_instansi" => "trim",
					"no_telp" => "trim",
					"email" => "trim",
					"website" => "trim",
					"kepala_instansi" => "trim",
					"no_sk" => "trim",
					"tanggal_berdiri" => "trim",
					"status_akreditasi" => "trim",
					"tanggal_akreditasi" => "trim",
					"logo1" => "trim",
					"logo2" => "trim",
					"logo3" => "trim",

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

	public function get_company_profil($where)
	{
		return $this->db->get_where("company_profil",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("company_profil",$where)->row();
	}
}