<?php

class M_employee extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_key  from (SELECT
				emp_no,emp_noktp,emp_name,emp_sex,emp_birthdate,
				emp_npwp,tahun_masuk,
				r1.reff_name as agama,
				r2.reff_name as pendidikan,
				r3.reff_name as jabatan,empcat_name,e.empcat_id,position_id,
				emp_active,emp_mail,absen_code,alamat_domisili,unit_name,emp_id AS id_key 
			FROM
				employee e
				left JOIN ms_reff r1 ON e.agama = r1.reff_id
				left JOIN ms_reff r2 ON e.pendidikan = r2.reff_id 
				left JOIN ms_reff r3 ON e.position_id = r3.reff_id 
				left Join ms_unit u on e.unit_id = u.unit_id
				left Join employee_categories ec on e.empcat_id = ec.empcat_id
				    )x where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
		select ".implode(',', $aColumns).",id_key  from (SELECT
		emp_no,emp_noktp,emp_name,emp_sex,emp_birthdate,
		emp_npwp,tahun_masuk,
		r1.reff_name as agama,
		r2.reff_name as pendidikan,
		r3.reff_name as jabatan,empcat_name,e.empcat_id,position_id,
		emp_active,emp_mail,absen_code,alamat_domisili,unit_name,emp_id AS id_key 
	FROM
		employee e
		left JOIN ms_reff r1 ON e.agama = r1.reff_id
		left JOIN ms_reff r2 ON e.pendidikan = r2.reff_id 
				left JOIN ms_reff r3 ON e.position_id = r3.reff_id 
				left join ms_unit u on e.unit_id = u.unit_id
				left join employee_categories ec on e.empcat_id = ec.empcat_id
				)x where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"emp_id",
				"emp_no"=> ["label" => "NO Pegawai"],
				"emp_noktp"=> ["label" => "No KTP"],
				//"emp_nokk",
				"emp_name"=> ["label" => "Nama Pegawai"],
				"emp_sex"=> [
					"label" => "Jenis Kelamin",
					"custom" => function ($a) {
						if ($a == 'L') {
							$condition = ["class" => "label-info", "text" => "Laki-Laki"];
						} else {
							$condition = ["class" => "label-succses", "text" => "Perempuan"];
						}
						return label_status($condition);
					}
				],
				"emp_birthdate"=> ["label" => "Tanggal Lahir"],
				//"emp_status",
				//"emp_couple",
				//"emp_phone",
				//"emp_address",
				//"emp_resident",
				//"emp_district",
				//"emp_city",
				"empcat_name"=> ["label" => "Kategori"],
				//"emp_npwp"=> ["label" => "No NPWP"],
				//"tahun_masuk",
				"unit_name"=> ["label" => "Ruangan"],
				//"position_id",
				"agama",
				"pendidikan",
				"jabatan",
				"emp_active" => [
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
				//"emp_born",
				"emp_mail"=> ["label" => "Email"],
				//"emp_type",
				"absen_code"=> ["label" => "Kode Absen"],
				//"emp_photo",
				//"tanggal_keluar",
				//"alamat_domisili"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"emp_no" => "trim",
					"emp_noktp" => "trim|required",
					"emp_nokk" => "trim",
					"emp_name" => "trim|required",
					"emp_sex" => "trim|required",
					"emp_birthdate" => "trim",
					"emp_status" => "trim|required",
					"emp_couple" => "trim",
					"emp_phone" => "trim",
					"emp_address" => "trim",
					"emp_resident" => "trim",
					"emp_district" => "trim",
					"emp_city" => "trim",
					"emp_prov" => "trim",
					"emp_npwp" => "trim",
					"tahun_masuk" => "trim|required",
					"unit_id" => "trim|integer|required",
					"position_id" => "trim|integer|required",
					"agama" => "trim|required",
					"pendidikan" => "trim",
					"emp_active" => "trim",
					"emp_born" => "trim",
					"emp_mail" => "trim",
					"emp_type" => "trim",
					"absen_code" => "trim",
					"emp_photo" => "trim",
					"tanggal_keluar" => "trim",
					"alamat_domisili" => "trim",
					"empcat_id" => "trim",

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

	public function get_employee($where = null)
	{
		return $this->db->get_where("employee",$where)->result();
	}

	public function get_employee2($where="",$select = "",$limit = "")
	{
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		if (is_array($where)) {
			$data =$this->db->get_where("employee",$where)->result();
		}else{
			$data = $this->db->where($where,null)
							 ->get("employee")
							 ->result();
		}
		return $data;
	}

	public function find_one($where)
	{
		return $this->db->get_where("employee",$where)->row();
	}
}