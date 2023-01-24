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
		//$button=$_POST['dtlPas'];	
		$post=$this->input->post();
      // print_R($post);die;
		$data['post']=$post;  
		//$data['button']=$button;
		$where = " DATE_FORMAT(absen_date, '%m-%Y') = '".$post["tanggal"]."'";
		$where .= "and last_kelas = '".$post["filter_unit"]."'";
		$where1 = " DATE_FORMAT(tanggal, '%m-%Y') = '".$post["tanggal"]."'"; 
		
		$data["datainout"] = $this->db->query("
		SELECT
	st_name,
	st_nis,
	json_arrayagg(
		json_object( 'tanggal', absen_date, 'jam_masuk', DATE_FORMAT( check_in, '%H:%i:%S' ), 'estimasi_in', late_duration_in, 'jam_keluar', DATE_FORMAT( check_out, '%H:%I:%S' ),'estimasi_out', late_duration_ot ) 
	) detail 
FROM
	absensi_siswa ab
	JOIN ms_siswa s ON ab.siswa_id = s.st_id
WHERE $where	
GROUP BY
	st_name,
	st_nis 
ORDER BY
	st_name
		")->result();		
		$data["libur"] = $this->db->query(" SELECT tanggal as hari from ms_libur WHERE $where1")->result();  

		// if($button=="Excel"){
		// 	$this->load->view("rekap_absensi/lap_rekap_inout",$data);
		// }else{
		// 	$html=$this->load->view("rekap_absensi/lap_rekap_inout",$data);
		// 	// $mpdf = new \Mpdf\Mpdf();		
		// 	// $mpdf->WriteHTML($html);
		// 	// $mpdf->Output();
		// }	
        $html=$this->load->view("rekap_absensi/lap_rekap_inout",$data);
	}


}
