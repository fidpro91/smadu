<?php 
if ($button=="Excel") {
    $now =$kelas->unit_name;
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=REKAP SISWA-".$now.".xls");
}

?>

?>
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
    <?php
    list($bulan,$tahun)=explode("-",$post['tanggal']);
    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tabel" align="center" style="font-size: 12px">
    	<tr>
    		<td colspan="2" align="center" style="font-size: 14px;"><strong>
    			Laporan Rekapitulasi Absensi Siswa
                <br>Periode <?=$bulan,'-',$tahun?>
                </strong> 
			</td>
    	</tr>
    </table>
<table border="1" align="center" width="100%" style="font-size: 12px; border-collapse: collapse;" >
    <tr>
        <td rowspan="2" align="center">No</td>
        <td rowspan="2" align="center">NAMA SISWA</td>
        <td rowspan="2" align="center">NIS</td>
        <td rowspan="2" align="center">KELAS</td>                
        <td colspan="<?=$tanggal?>" align="center">TANGGAL</td>
        
    </tr>
    <tr>
        <?php
       
        for ($i=1; $i < $tanggal+1; $i++) {
            echo "<td>$i</td>";
             
        }
        
        ?>
    </tr>
    <tbody>
        <?php
            foreach ($datainout as $ind => $value) {
                echo "<tr>
                <td>".($ind+1)."</td>
                <td>$value->st_name</td>
                <td>$value->st_nis</td>
                <td>$value->unit_name</td>";
                $datainout = json_decode($value->detail);   
                $total = [];          
               for ($x=1; $x < $tanggal+1; $x++) {
                    $color="";                   
                   foreach ($datainout as $key => $value) {
                        $tanggalAbsen = date("d",strtotime($value->tanggal)); 
                       // print_r($tanggalAbsen);   
                                                           
                       if ($x==$tanggalAbsen ) {
                        $type = "";
                        if($value->type==1){
                            $type = "Masuk";
                        }else if($value->type==2){
                            $type = "Izin/Sakit";
                        }else if($value->type==3){
                            $type = "Alpa";
                        }

                        if($value->type == 1){
                            $absen= "CHECKIN : ".$value->jam_masuk ."<br>CHECKOUT : ". $value->jam_keluar."";
                        }else{
                            $absen= "<b>". $type."</b>";
                        }
                            
                           break;          
                        }else{
                            $absen="";           
                        
                        }  
                                   
                   }    
                                    
                   if(empty($absen)) {                    
                    echo "<td $color style='background-color:red'>".$absen."</td>";                   
                    }else{
                        echo "<td $color>$absen"."</td>"; }                      
                     
                                       
                    
                              
                    
                                     
               }
 
            }
        ?>
    </tbody>
</table>
