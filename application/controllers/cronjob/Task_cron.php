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

    public function auto_checkout_absen()
    {
        $data = $this->db->where([
                        "absen_date = '".date('Y-m-d')."" => null,
                        "checkout"  => null
                        ])->get("absensi_pegawai");
        $jadwal = $this->db->get_where("jam_kerja_harian",["hari='".date('N')."'"=>null])->row();
        if ($data->num_rows()>0) {
            foreach ($data->result() as $key => $value) {
                $this->db->where(["absen_id"=>$value->absen_id])->update("absensi_pegawai",[
                    "checkout"      => date('Y-m-d')." ".$jadwal->jam_pulang,
                    "absen_note"    => "Checkout by sistem"
                ]);
            }
        }        
    }

}
?>