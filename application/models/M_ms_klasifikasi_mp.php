<?php

class M_ms_klasifikasi_mp extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",klas_mk_id as id_key  from ms_klasifikasi_mp where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",klas_mk_id as id_key  from ms_klasifikasi_mp where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"klas_mk_id",
				"klas_mk_kode",
				"klas_mk_nama"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"klas_mk_id" => "trim|integer|required",
					"klas_mk_kode" => "trim",
					"klas_mk_nama" => "trim",

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

	public function get_ms_klasifikasi_mp()
	{
		return $this->db->get("ms_klasifikasi_mp")->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_klasifikasi_mp",$where)->row();
	}
}