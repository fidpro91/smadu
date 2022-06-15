<?php 
if ($button=="Excel") {
    $now = date('d-m-Y');
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=siswa-".$now.".xls");
}?>



<style type="text/css">    
.tabel{
	font-size:13px;
}
.tabel tr{
	border-bottom: solid 1px black;
	border-top: solid 1px black;
	padding: 3px 3px;
}
td{
	padding: 3px 3px;
}
</style>
<div style="text-align: left;">
</style>
   
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tabel" align="center" style="font-size: 12px">
    	<tr>
    		<td colspan="2" align="center" style="font-size: 14px;"><strong>
    			Laporan Rekapitulasi Absensi Siswa
                <br>
                </strong> 
			</td>
    	</tr>
    </table>
   
<table border="1" align="center" width="100%" style="font-size: 12px; border-collapse: collapse;" >
    <tr>        
        <td  align="center">NISN</td>
        <td  align="center">NAMA SISWA</td>        
        <td  align="center">ALAMAT</td> 
        <td  align="center">Tempat Lahir</td> 
        <td  align="center">Tgl Lahir</td> 
        <td  align="center">Ortu</td> 
        <td  align="center">No hp</td>   
        <td  align="center">Kelas</td> 
        <td> Jenis Kelamin </td>
        <td  align="center">Tahun Masuk</td> 
        <td  align="center">Pin</td>
    </tr>
    
    <tbody>
        <?php
        // print_r($dataNilai);
            foreach ($siswa as $ind => $value)     //print_r($value->st_nis);die;        
            {              
                echo "<tr>               
                <td>$value->st_nis</td>
                <td>$value->st_name</td>
                <td>$value->st_address</td>
                <td>$value->st_born</td>
                <td>$value->st_birthdate</td>
                <td>$value->st_father</td>
                <td>$value->st_phone</td>
                <td>$value->unit_name</td>
                <td>$value->st_sex</td>
                <td>$value->st_th_masuk</td>
                <td>$value->finger_id</td>               
                ";                   
              
            } 
            
        ?>     
   
    </tbody>
</table>
