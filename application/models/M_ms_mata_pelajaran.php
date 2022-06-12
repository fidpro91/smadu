<?php

class M_ms_mata_pelajaran extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_mp as id_key  from ms_mata_pelajaran mp
				join ms_klasifikasi_mp ks on mp.klasifikasi_mp = ks.klas_mk_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_mp as id_key  from ms_mata_pelajaran mp
				join ms_klasifikasi_mp ks on mp.klasifikasi_mp = ks.klas_mk_id where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"kode_mp",
				"mata_pelajaran",			
				"klas_mk_nama",
				"is_active" => [
					"label" => "Status",
					"custom" => function ($a) {
						if ($a == 't') {
							$condition = ["class" => "label-primary", "text" => "Aktif"];
						} else {
							$condition = ["class" => "label-danger", "text" => "Non Aktif"];
						}
						return label_status($condition);
					}
				],
				//"id_mp"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"mata_pelajaran" => "trim|required",
					"is_active" => "trim",
					"kode_mp" => "trim|required",
					"klasifikasi_mp" => "trim|integer|required",
					"id_mp" => "trim|integer",

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

	public function get_ms_mata_pelajaran($where)
	{
		return $this->db->get_where("ms_mata_pelajaran",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_mata_pelajaran",$where)->row();
	}

	public function get_ms_mata_pelajaran2($where="",$select = "",$limit = "")
	{
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		if (is_array($where)) {
			$data =$this->db->get_where("ms_mata_pelajaran",$where)->result();
		}else{
			$data = $this->db->where($where,null)
							 ->get("ms_mata_pelajaran")
							 ->result();
		}
		return $data;
	}
}