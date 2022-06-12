<?php

class M_jam_kerja_harian extends CI_Model
{

	public function get_data($sLimit, $sWhere, $sOrder, $aColumns)
	{
		$data = $this->db->query("
				select " . implode(',', $aColumns) . ",id as id_key  from jam_kerja_harian where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere, $aColumns)
	{
		$data = $this->db->query("
				select " . implode(',', $aColumns) . ",id as id_key  from jam_kerja_harian where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
			"hari"=>[
				"custom" => function($a){
					return show_hari($a);
				}
			],
			"jam_masuk",
			"toleransi_keterlambatan"=>[
				"custom" => function($a){
					return ($a." Menit");
				}
			],
			"jam_istirahat",
			"jam_pulang",
			"jadwal_untuk"=>[
				"custom" => function($a){
					if ($a == '1') {
						$condition = ["class" => "label-primary", "text" => "Pegawai"];
					} else {
						$condition = ["class" => "label-success", "text" => "Siswa"];
					}
					return label_status($condition);
				}
			],
			"keterangan"
		];
		return $col;
	}

	public function rules()
	{
		$data = [
			"hari" => "trim|integer|required",
			"jam_masuk" => "trim|required",
			"toleransi_keterlambatan" => "trim",
			"jam_istirahat" => "trim",
			"jam_pulang" => "trim",
			"jadwal_untuk" => "trim|integer|required",
			"keterangan" => "trim",

		];
		return $data;
	}

	public function validation()
	{
		foreach ($this->rules() as $key => $value) {
			$this->form_validation->set_rules($key, $key, $value);
		}

		return $this->form_validation->run();
	}

	public function get_jam_kerja_harian($where)
	{
		return $this->db->get_where("jam_kerja_harian", $where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("jam_kerja_harian", $where)->row();
	}
}
