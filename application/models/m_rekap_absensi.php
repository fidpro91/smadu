<?php

class m_rekap_absensi extends CI_Model {

	public function get_laporan($tgl1,$tgl2)
	{
		$data = $this->db->query("
        SELECT
        st_nim,
        st_name,
        json_arrayagg( json_object( 'tanggal', absen_date, 'jns_absen', absen_type ) ) detail 
    FROM
        absensi_siswa ab
        JOIN ms_siswa s ON ab.siswa_id = s.st_id 
    where date(absen_date) between '$tgl1'  and '$tgl2'
    GROUP BY
        st_name,st_nim
    ORDER BY
        st_name
			")->result();
		return $data;
	}

}