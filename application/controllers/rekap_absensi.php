<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

class rekap_absensi extends MY_Generator
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
		$this->theme('rekap_absensi/index');
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
		st_nis,
		st_name,
		is_verified,
		unit_name,
		json_arrayagg( json_object( 'tanggal', absen_date, 'jns_absen', absen_type ) ) detail 
	FROM
		absensi_siswa ab
		JOIN ms_siswa s ON ab.siswa_id = s.st_id
		left join ms_unit u on s.last_kelas = u.unit_id 
		where $where
		and is_verified = '".$post["filter_verifikasi"]."'		
	GROUP BY
		st_name,st_nis,is_verified,unit_name
	ORDER BY
		st_name
			
	")->result();
	
		if($button=="Excel"){
			$this->load->view("rekap_absensi/lap_rekap",$data);
		}else{
			$html=$this->load->view("rekap_absensi/lap_rekap",$data,true);
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'orientation' => 'L'
		]);		
		$mpdf->WriteHTML($html);	
		$mpdf->Output();

		}		 

	}

}
