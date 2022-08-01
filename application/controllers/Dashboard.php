<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data["siswa"] = $this->db->get_where("ms_siswa",[
			"st_active" => "t"
		])->num_rows();
		$data["instansi"] = $this->db->get("company_profil")->row();
		$data["user_activity"] = $this->db->join("ms_user mu","mu.user_id=ua.user_id")
									 ->get("user_activity ua")
									 ->result();
		$data["pegawai"] = $this->db->get_where("employee",[
			"emp_active" => "t"
		])->num_rows();
		$data["unit_count"] = $this->db->get_where("ms_unit",[
			"unit_active" => "t"
		])->num_rows();
		$data["mataPelajaran"] = $this->db->get_where("ms_mata_pelajaran",[
			"is_active" => "t"
		])->num_rows();
		$unit = $this->db->query("
		SELECT DISTINCT concat(SUBSTRING_INDEX(unit_name,' ',2),' - ',mc.nama)unit_nama FROM ms_unit mu
		JOIN ms_category_unit mc ON mu.unit_type = mc.catunit_id
		WHERE unit_code like '01.%'")->result();
		foreach ($unit as $key => $value) {
			$kat[$value->unit_nama] = $value->unit_nama;
		}
		
		$data['unit'] = $kat;
		foreach ($this->db->get_where("ms_unit",["unit_active"=>'t'])->result() as $key => $value) {
			$unit_kerja[$value->unit_id] = $value->unit_name;
		}
		$data['unitKerja'] = $unit_kerja;

		$this->theme('dashboard/dashboard',$data,get_class($this));
	}

	public function get_data_chart()
	{
		$post=$this->input->post();
		list($kelas,$room) = explode('-',$post['filter_class']);
		$data = $this->db->query("
			SELECT x.bulan,JSON_ARRAYAGG(
			JSON_OBJECT('f1',x.absen_type,'f2',x.jml))detail FROM (
			SELECT EXTRACT(month FROM absen_date)bulan,absen_type,count(*)jml FROM absensi_siswa ab
			join ms_siswa ms on ms.st_id = ab.siswa_id
			join ms_unit mu on ms.last_kelas = mu.unit_id
			join ms_category_unit mc on mu.unit_type = mc.catunit_id
			where mu.unit_name like '%".trim($kelas)."%' and mc.nama like '%".trim($room)."%'
			GROUP BY EXTRACT(month FROM absen_date),absen_type
			)x
			GROUP BY x.bulan
		")->result_array();
		$response["ykeys"] = ["m","i","a"];
		$response["xkey"] = "bulan";
		foreach (get_absen() as $key => $value) {
			if ($value['id'] != 0 && $value['id'] != 4) {
				$label[] = $value['text'];
			}
		}
		$response["labels"] = array_values($label);
		$resp = [];
		for ($i=1; $i < 13; $i++) { 
			$datachild = array_values(array_filter($data, function ($var) use($i){
				return ($var['bulan'] == $i);
			}));
			$resp[$i]['bulan'] = get_namaBulan($i);
			foreach (get_absen() as $key => $value) {
				if ($value['id'] != 0 && $value['id'] != 4) {
					if ($datachild) {
						$absen = json_decode($datachild[0]['detail'],true);
						$key_abs = array_search($value['id'], array_column($absen, 'f1'));
						if ($key_abs !== false) {
							$resp[$i][$value['code']] = $absen[$key_abs]['f2'];
						}else{
							$resp[$i][$value['code']] = 0;
						}
					}else{
						$resp[$i][$value['code']] = 0;
					}
				}
			}
		}
		$response['data'] = array_values($resp);
		echo json_encode($response);
	}

	public function get_data_chart_absen_pegawai()
	{
		$post = $this->input->post();
		$data = $this->db->query("
			SELECT x.bulan,JSON_ARRAYAGG(
			JSON_OBJECT('f1',x.absen_type,'f2',x.jml))detail FROM (
			SELECT EXTRACT(month FROM absen_date)bulan,absen_type,count(*)jml FROM absensi_pegawai ap
			join employee e on e.emp_id = ap.emp_id
			/* where e.unit_id = '".$post['filter_unit']."' */
			GROUP BY EXTRACT(month FROM absen_date),absen_type
			)x
			GROUP BY x.bulan
		")->result_array();
		$response["ykeys"] = ["m","i","a"];
		$response["xkey"] = "bulan";
		foreach (get_absen_pegawai() as $key => $value) {
			if ($value['id'] != 0 && $value['id'] != 4) {
				$label[] = $value['text'];
			}
		}
		$response["labels"] = array_values($label);
		$resp = [];
		for ($i=1; $i < 13; $i++) { 
			$datachild = array_values(array_filter($data, function ($var) use($i){
				return ($var['bulan'] == $i);
			}));
			$resp[$i]['bulan'] = get_namaBulan($i);
			foreach (get_absen() as $key => $value) {
				if ($value['id'] != 0 && $value['id'] != 4) {
					if ($datachild) {
						$absen = json_decode($datachild[0]['detail'],true);
						$key_abs = array_search($value['id'], array_column($absen, 'f1'));
						if ($key_abs !== false) {
							$resp[$i][$value['code']] = $absen[$key_abs]['f2'];
						}else{
							$resp[$i][$value['code']] = 0;
						}
					}else{
						$resp[$i][$value['code']] = 0;
					}
				}
			}
		}
		$response['data'] = array_values($resp);
		echo json_encode($response);
	}

	public function get_data_chart_siswa()
	{
		
		$data = $this->db->query("
			SELECT SUBSTRING_INDEX(unit_name,' ',3)kelas,count(*)jml FROM ms_siswa ms
			JOIN ms_unit mu ON ms.last_kelas = mu.unit_id
			GROUP BY SUBSTRING_INDEX(unit_name,' ',3)
		")->result();
		$resp=[];
		foreach ($data as $key => $value) {
			$resp[] = [
				"label" => $value->kelas,
				"value"	=> $value->jml
			];
		}
		echo json_encode($resp);
	}
	
	public function get_data_chart_pegawai()
	{
		
		$data = $this->db->query("
			SELECT ec.empcat_name,count(*)jml FROM employee e
			JOIN employee_categories ec ON e.empcat_id = ec.empcat_id
			GROUP BY ec.empcat_name
		")->result();
		$resp=[];
		foreach ($data as $key => $value) {
			$resp[] = [
				"label" => $value->empcat_name,
				"value"	=> $value->jml
			];
		}
		echo json_encode($resp);
	}
}
