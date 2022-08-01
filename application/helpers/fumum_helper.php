<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_status(){
	return ['Menikah','Lajang','Janda','Duda'];
}

function get_agama(){
	return ['Islam','Kristen','Katolik','Budha','Hindu','Konghucu'];
}

function get_pendidikan(){
	return ['SD','SMP','SMA/SMK/MA','S1','S2','S3'];
}

function get_hari(){
	return [
			["id"=>"1", "text"=> "Senin"],
			["id"=>"2", "text" => "Selasa"],
			["id"=>"3", "text" => "Rabu"],
			["id"=>"4", "text"=> "Kamis"],
			["id"=>"5", "text"=> "Jum'at"],
			["id"=>"6", "text"=> "Sabtu"],
			["id"=>"7", "text"=> "Minggu"],
		];
}

function get_absensi(){
	return [
			["id"=>"0", "text"=> "Alpha"],
			["id"=>"1", "text" => "Masuk"],
			["id"=>"2", "text" => "Ijin/Sakit"],
			["id"=>"3", "text" => "Cuti"],
			["id"=>"4", "text" => "Libur"],
		];
}

function get_namaBulan($data = null){
	$bulan = [
		"",
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
	];
	if ($data) {
		if (strripos($data,'-')>0) {
			$data=explode("-",$data);
			$data = $bulan[($data[0]-1)].' '.$data[1];
		}else{
			$data = $bulan[(int)$data];
		}
		return $data;
	}else{
		return $bulan;
	}
}

function show_hari($id){
	foreach (get_hari() as $key => $value) {
		if ($id == $value['id']) {
			return $value['text'];
			break;
		}
	}
}

function get_semester($id=null)
{
	$data = [
		["id"=>"1","text"=>"Ganjil"],
		["id"=>"2","text"=>"Genap"],
	];
	if ($id) {
		$key = array_search($id, array_column($data, 'id'));
        $data=($data[$key]['text']);
	}
	return $data;
}

function get_absen($id=null){
	$data =  [
			["id"=>"0", "code" => "s", "text" => "SEMUA"],
			["id"=>"1", "code" => "m", "text" => "MASUK"],
			["id"=>"2", "code" => "i", "text" => "IJIN/SAKIT"],
			["id"=>"3", "code" => "a", "text"=> "ALPA"],
			["id"=>"4", "text" => "l", "text"=> "LIBUR"],
		];
	if ($id) {
		$key = array_search($id, array_column($data, 'id'));
		$data=($data[$key]['text']);
	}
	return $data;
}

function get_absen_pegawai($id=null){
	$data =  [
			["id"=>"0", "code" => "s", "text" => "SEMUA"],
			["id"=>"1", "code" => "m", "text" => "CUTI"],
			["id"=>"2", "code" => "m", "text" => "MASUK"],
			["id"=>"3", "code" => "i", "text" => "IJIN/SAKIT"],
			["id"=>"4", "code" => "l", "text"=> "LIBUR"],
			["id"=>"5", "code" => "a", "text"=> "ALPA"],
			["id"=>"6", "text" => "p", "text"=> "PIKET"],
		];
	if ($id) {
		$key = array_search($id, array_column($data, 'id'));
		$data=($data[$key]['text']);
	}
	return $data;
}

function convert_currency($angka)
{
	if(!$angka) {
		return 0;
	}
	$rupiah= number_format($angka,2,'.',',');
	return $rupiah;
}

function remove_currency($angka)
{
	$rupiah= str_replace(",","", $angka);
	return $rupiah;
}

function selisih_waktu($date1,$date2)
{
	$date1=date_create($date1);
	$date2=date_create($date2);
	$diff=date_diff($date1,$date2);
	$resp = [
		"jam" 		=> $diff->format('%r%h'),
		"menit"		=> $diff->format('%r%i'),
		"detik"		=> $diff->format('%r%s'),
		"total"		=> ($diff->format('%r%h')*60 + $diff->format('%r%i') + ($diff->format('%r%s')/60))
	];
	return $resp;
}
?>