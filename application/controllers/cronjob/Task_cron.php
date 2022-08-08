<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function auto_insert_absen_siswa()
    {
        $this->db->query("
            INSERT INTO absensi_siswa(absen_code,absen_date,absen_type,siswa_id,is_verified)
            SELECT s.finger_id,now(),3,s.st_id,'t' FROM ms_siswa s
            LEFT JOIN absensi_siswa abs ON s.st_id = abs.siswa_id AND abs.absen_date = date(now())
            WHERE abs.absen_id IS NULL
        ");
    }

    public function auto_insert_absen_pegawai()
    {
        $this->db->query("
            INSERT INTO absensi_pegawai(emp_absen_code,absen_date,absen_type,emp_id,is_verified)
            SELECT e.emp_no,now(),5,e.emp_id,'t' FROM employee e
            LEFT JOIN absensi_pegawai abs ON e.emp_id = abs.emp_id AND abs.absen_date = date(now())
            WHERE abs.absen_id IS NULL
        ");
    }

    public function auto_insert_absen_libur()
    {
        $liburWajib = $this->db->where("(hari='".date('N')."' OR tanggal = '".date('Y-m-d')."')",null)
                        ->get("ms_libur");
        if ($liburWajib->num_rows()>0) {
            foreach ($liburWajib->result() as $key => $value) {
                if ($value->libur_type == 3) {
                    $this->db->query("
                        INSERT INTO absensi_siswa(absen_code,absen_date,absen_type,siswa_id,is_verified)
                        SELECT s.finger_id,now(),4,s.st_id,'t' FROM ms_siswa s;
                        INSERT INTO absensi_pegawai(emp_absen_code,absen_date,absen_type,emp_id,is_verified)
                        SELECT e.emp_no,now(),4,e.emp_id,'t' FROM employee e;
                    ");
                }elseif($value->libur_type == 1){
                    $this->db->query("
                        INSERT INTO absensi_siswa(absen_code,absen_date,absen_type,siswa_id,is_verified)
                        SELECT s.finger_id,now(),4,s.st_id,'t' FROM ms_siswa s;
                    ");
                }elseif($value->libur_type == 2){
                    $this->db->query("
                        INSERT INTO absensi_pegawai(emp_absen_code,absen_date,absen_type,emp_id,is_verified)
                        SELECT e.emp_no,now(),4,e.emp_id,'t' FROM employee e;
                    ");
                }
                
            }
        }        
    }

    public function get_scanlog()
	{
		$this->finger = $this->load->database("finger",true);
		$dataScan = $this->finger->order_by("scan_date")->get("att_log")->result();
		$this->db->trans_begin();
		$dataInsert=[];
		foreach ($dataScan as $key => $value) {
			$pin = $value->pin;
			$dataSiswa = $this->db->get_where("ms_siswa",["finger_id"=>$pin]);
			if ($dataSiswa->num_rows()>0) {
				$dataSiswa = $dataSiswa->row();
				$tglabsen = date("Y-m-d",strtotime($value->scan_date));
				$absenSiswa = array_filter($dataInsert, function ($var) use($pin,$tglabsen){
					return ($var['absen_code'] == $pin && $var['absen_date'] == $tglabsen);
				});
				$cekAbsen = $this->db->get_where("absensi_siswa",[
								"absen_code"	=> $pin,
								"absen_date"	=> $tglabsen
							])->num_rows();
				if (count($absenSiswa)==0 && $cekAbsen==0) {
					$jadwal = $this->db->get_where("jam_kerja_harian",[
						"hari"				=> date("w",strtotime($value->scan_date)),
						"jadwal_untuk"		=> $this->setting->kode_jadwal_siswa
					])->row("jam_masuk");
					$jadwal = date("Y-m-d",strtotime($value->scan_date))." ".$jadwal;
					$selisih = selisih_waktu($value->scan_date,$jadwal);
					$dataInsert[$key] = [
						"absen_code" => $pin,
						"absen_date" => date("Y-m-d",strtotime($value->scan_date)),
						"check_in"	 => $value->scan_date,
						"absen_type" => 1,
						"user_created" => $this->session->user_id,
						"siswa_id"	   => $dataSiswa->st_id,
						"late_duration_in" => $selisih["total"],
						"is_verified"  => "f"
					];
				}
			}
		}
		if (count($dataInsert) > 0) {
			$this->db->insert_batch("absensi_siswa",$dataInsert);
		}
		$resp = array();
		if ($this->db->trans_status() !== false) {
			$this->db->trans_commit();
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil direload';
		}else{
			$this->db->trans_rollback();
			$err = $this->db->error();
			$resp['code'] = '201';
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

}
?>