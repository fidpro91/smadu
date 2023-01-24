<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

class rekap_absen_pegawai extends MY_Generator
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
		$this->theme('rekap_pegawai/index');
	}
	public function show_laporan()
	{ 	
		$button=$_POST['dtlPas'];	
		$post=$this->input->post();
		$data['post']=$post;  
		$data['button']=$button;
		$where = " DATE_FORMAT(absen_date, '%m-%Y') = '".$post["tanggal"]."'"; 
		if (!empty($post["filter_absen"])) {
			$where .= " AND absen_type = ".$post["filter_absen"]."";
		}	
		if (!empty($post["filter_unit"])) {
			$where .= " AND last_kelas = ".$post["filter_unit"]."";
		}
		$data["dataNilai"] = $this->db->query(" SELECT
		emp_name,
		emp_noktp,	
		json_arrayagg( json_object( 'tanggal', absen_date, 'jns_absen', absen_type ) ) detail 
	FROM
		absensi_pegawai ap
		JOIN employee e ON ap.emp_id = e.emp_id
	
	WHERE
		$where
	GROUP BY
		emp_name,
		emp_noktp	
	ORDER BY
		emp_name
			
	")->result();		
    
		if($button=="Excel"){
			$this->load->view("rekap_pegawai/rekap_absen_pegawai",$data);
		}else{
			$html=$this->load->view("rekap_pegawai/rekap_absen_pegawai",$data,true);
			$mpdf = new \Mpdf\Mpdf();		
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		}	
	}

	public function show_rekap_inout()
	{
		$this->theme('rekap_pegawai/form_rekap_in_out');
	}

	public function show_report_in_out()
	{ 	
		$button=$_POST['dtlPas'];	
		$post=$this->input->post();
		$data['post']=$post;  
		$data['button']=$button;
		$where = " DATE_FORMAT(absen_date, '%m-%Y') = '".$post["tanggal"]."'";
		$where1 = " DATE_FORMAT(tanggal, '%m-%Y') = '".$post["tanggal"]."'"; 
		if (!empty($post["filter_absen"])) {
			$where .= " AND absen_type = ".$post["filter_absen"]."";
		}	
		if (!empty($post["filter_unit"])) {
			$where .= " AND last_kelas = ".$post["filter_unit"]."";
		}
		$data["datainout"] = $this->db->query("SELECT
		emp_name,
		emp_noktp,
		json_arrayagg( json_object( 'tanggal', absen_date, 'jam_masuk', DATE_FORMAT(check_in,'%H:%i:%S'),'estimasi',late_duration_in,'jam_keluar', DATE_FORMAT(check_out,'%H:%I:%S') ) ) detail 
		FROM
		absensi_pegawai ap
		JOIN employee e ON ap.emp_id = e.emp_id 
		WHERE $where 
		GROUP BY
		emp_name,
		emp_noktp 
		ORDER BY
		emp_name			
		")->result();		
		$data["libur"] = $this->db->query(" SELECT tanggal as hari from ms_libur WHERE $where1")->result();    
		if($button=="Excel"){
			$this->load->view("rekap_pegawai/rekap_in_out",$data);
		}else{
			$html=$this->load->view("rekap_pegawai/rekap_in_out",$data);
			// $mpdf = new \Mpdf\Mpdf();		
			// $mpdf->WriteHTML($html);
			// $mpdf->Output();
		}	
	}


}
