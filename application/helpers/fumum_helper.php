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
			["id"=>"0", "text"=> "Minggu"],
			["id"=>"1", "text" => "Senin"],
			["id"=>"2", "text" => "Selasa"],
			["id"=>"3", "text"=> "Rabu"],
			["id"=>"4", "text"=> "Kamis"],
			["id"=>"5", "text"=> "Jum'at"],
			["id"=>"6", "text"=> "Sabtu"],
		];
}

function get_absensi(){
	return [
			["id"=>"0", "text"=> "Alpha"],
			["id"=>"1", "text" => "Masuk"],
			["id"=>"2", "text" => "Ijin/Sakit"],
			["id"=>"3", "text" => "Cuti"],
		];
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
		["id"=>"1","text"=>"SEMESTER 1"],
		["id"=>"2","text"=>"SEMESTER 2"],
		["id"=>"3","text"=>"SEMESTER 3"],
		["id"=>"4","text"=>"SEMESTER 4"],
		["id"=>"5","text"=>"SEMESTER 5"],
		["id"=>"6","text"=>"SEMESTER 6"],
		["id"=>"7","text"=>"SEMESTER 7"],
	];
	if ($id) {
		$key = array_search($id, array_column($data, 'id'));
        $data=($data[$key]['text']);
	}
	return $data;
}

function get_absen(){
	return [
			["id"=>"1", "text" => "CUTI/IJIN"],
			["id"=>"2", "text" => "MASUK"],
			["id"=>"3", "text"=> "LEMBUR"],
			["id"=>"4", "text"=> "LIBUR"],
			["id"=>"5", "text"=> "ALPA"],
		];
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
?>