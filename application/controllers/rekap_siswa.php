<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

class rekap_siswa extends MY_Generator
{
	public function __construct()
	{
		parent::__construct();
        $this->datascript->lib_datepicker();
		$this->datascript->lib_select2();
		//$this->load->model('m_rekap_absensi');
	}

	public function index()
	{
		$this->theme('rekap_absensi/rekap_siswa');
	}

	public function show_report_in_out()
	{ 	
		$button=$_POST['dtlPas'];	
		$post=$this->input->post();
      
		$data['post']=$post;  
		$data['button']=$button;
		$where = " DATE_FORMAT(absen_date, '%m-%Y') = '".$post["tanggal"]."'";
		$sWhere = "last_kelas = '".$post["filter_unit"]."'";
		$where1 = " DATE_FORMAT(tanggal, '%m-%Y') = '".$post["tanggal"]."'"; 
		
		$data["datainout"] = $this->db->query("
		SELECT st_nis,st_name,x.detail from ms_siswa s
		left join (
		SELECT
		siswa_id,
			json_arrayagg(
				json_object(
					'tanggal',
					absen_date,
					'jam_masuk',
					DATE_FORMAT( check_in, '%H:%i:%S' ),
					'estimasi_in',
					late_duration_in,
					'jam_keluar',
					DATE_FORMAT( check_out, '%H:%i:%S' ),
					'estimasi_out',
					late_duration_ot,
					'type',
					absen_type	 
				) 
			) detail 
		FROM
			absensi_siswa ab	
		WHERE
		$where
		GROUP BY
			siswa_id ) x on s.st_id = x.siswa_id
			WHERE $sWhere
	
	

		")->result();		
		$data["libur"] = $this->db->query(" SELECT tanggal as hari from ms_libur WHERE $where1")->row();  
		$data["kelas"] = $this->db->get_where("ms_unit",array('unit_id'=>$post["filter_unit"]))->row();
//print_r($button);die;
		if($button=="Excel"){
			$this->load->view("rekap_absensi/lap_rekap_inout",$data;			
		}else{
			$html=$this->load->view("rekap_absensi/lap_rekap_inout",$data,true);
			$mpdf = new \Mpdf\Mpdf();		
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		}	
        //$html=$this->load->view("rekap_absensi/lap_rekap_inout",$data);
	}


}
