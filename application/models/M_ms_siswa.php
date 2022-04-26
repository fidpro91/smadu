<?php

class M_ms_siswa extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",st_id as id_key  from ms_siswa m
				left join ms_reff r on m.religion_id = r.reff_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",st_id as id_key  from ms_siswa m
				left join ms_reff r on m.religion_id = r.reff_id where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"st_nim"=> ["label"=>"NIS"],
				//"st_noktp",
				//"st_nokk",
				"st_name"=> ["label"=>"Nama Siswa"],
				"st_sex"=> [
					"label" => "Jenis Kelamin",
					"custom" => function ($a) {
						if ($a == 'L') {
							$condition = ["class" => "label-info", "text" => "Laki-Laki"];
						} else {
							$condition = ["class" => "label-success", "text" => "Perempuan"];
						}
						return label_status($condition);
					}
				],
				"st_birthdate"=> ["label"=>"Tgl Lahir"],
				//"st_father",
				//"st_mother",
				"st_phone"=> ["label"=>"Telepon"],
				"st_address"=> ["label"=>"Alamat"],
				//"st_resident",
				//"st_district",
				//"st_city",
				//"st_prov",
				"reff_name"=> ["label"=>"Agama"],
				//"st_regby",
				"st_active" => [
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
				//"st_born",
				//"user_id",
				//"user_act",
				//"st_email",
				"st_th_masuk"=> ["label"=>"Tahun Masuk"],
				//"st_id",
				//"last_kelas",
				//"photo"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"st_nim" => "trim|required",
					//"st_noktp" => "trim|required",
					"st_nokk" => "trim",
					"st_name" => "trim|required",
					"st_sex" => "trim|required",
					"st_birthdate" => "trim",
					"st_father" => "trim",
					"st_mother" => "trim",
					"st_phone" => "trim",
					"st_address" => "trim",
					"st_resident" => "trim",
					"st_district" => "trim",
					"st_city" => "trim",
					"st_prov" => "trim",
					"religion_id" => "trim|integer",
					//"st_regby" => "trim|integer",
					"st_active" => "trim",
					"st_born" => "trim",
					//"user_id" => "trim|integer",
					"user_act" => "trim",
					"st_email" => "trim",
					"st_th_masuk" => "trim",
					"last_kelas" => "trim",
					"photo" => "trim",
					"finger_id" => "trim|integer",
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

	public function get_ms_siswa($where)
	{
		return $this->db->get_where("ms_siswa",$where)->result();
	}

	public function get_ms_siswa2($where="",$select = "",$limit = "")
	{
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		if (is_array($where)) {
			$data =$this->db->get_where("ms_siswa",$where)->result();
		}else{
			$data = $this->db->where($where,null)
							 ->get_where("ms_siswa",[
								 "st_active" => "t"
							 ])
							 ->result();
		}
		return $data;
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_siswa",$where)->row();
	}
}