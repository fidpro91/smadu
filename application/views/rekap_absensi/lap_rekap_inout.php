

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
    			Laporan Rekapitulasi Absensi Pegawai
                <br>Periode <?=$bulan,'-',$tahun?>
                </strong> 
			</td>
    	</tr>
    </table>
<table border="1" align="center" width="100%" style="font-size: 12px; border-collapse: collapse;" >
    <tr>
        <td rowspan="2" align="center">No</td>
        <td rowspan="2" align="center">NO KTP</td>
        <td rowspan="2" align="center">NAMA PEGAWAI</td>               
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
                <td>$value->st_nis</td>";
                $datainout = json_decode($value->detail);   
                $total = [];          
               for ($x=1; $x < $tanggal+1; $x++) {
                    $color="";                   
                   foreach ($datainout as $key => $value) {
                        $tanggalAbsen = date("d",strtotime($value->tanggal));    
                                                               
                       if ($x==$tanggalAbsen ) {
                           $absen= "CHECKIN : ".$value->jam_masuk ."<br>CHECKOUT : ". $value->jam_keluar."<br>estimasi in : ". $value->estimasi_in.
                           "<br>estimasi out : ". $value->estimasi_out;  
                           
                            if ($value->estimasi_in && $value->estimasi_out >0){
                                $color = "style='background-color:yellow'";
                            }else if ($value->estimasi_in && $value->estimasi_out=='0'){
                                $color = "style='background-color:green'";
                            }else{
                                $color = "style='background-color:orange'";
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
