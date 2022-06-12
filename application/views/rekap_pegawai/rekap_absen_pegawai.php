
<?php 
if ($button=="Excel") {
    $now = date('d-m-Y');
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Rekab Absen Pegawai-".$now.".xls");
}

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
<<<<<<< HEAD
        <td colspan="<?=$tanggal + 1?>" align="center">TANGGAL</td>
=======
        <td colspan="<?=$tanggal?>" align="center">TANGGAL</td>
        <td colspan="<?=count(get_absen())?>" align="center">Total</td>
>>>>>>> 4f229f012e9d0a8a07e312b74becd22a91ed6ff9
    </tr>
    <tr>
        <?php
        for ($i=1; $i < $tanggal+1; $i++) {
        echo "<td>$i</td>";
        }
<<<<<<< HEAD
=======
        foreach (get_absen() as $key => $abs) {
            if ($abs['id']>0) {
             echo "<td>".$abs["text"]."</td>";
            }
         }
>>>>>>> 4f229f012e9d0a8a07e312b74becd22a91ed6ff9
        ?>
    </tr>
    <tbody>
        <?php
            foreach ($dataNilai as $ind => $value) {
                echo "<tr>
                <td>".($ind+1)."</td>
                <td>$value->emp_noktp</td>
                <td>$value->emp_name</td>";
<<<<<<< HEAD
                $detailNilai = json_decode($value->detail);
                
                for ($x=0; $x < $tanggal+1; $x++) {
                    foreach ($detailNilai as $key => $value) {
                        $tanggalAbsen = date("d",strtotime($value->tanggal));
                        if ($x==$tanggalAbsen) {
                            $absen=get_absen($value->jns_absen);
                            break;
                        }else{
                            $absen="";
                        }
                    }
                    echo "<td>$absen</td>";
                }
=======
                $detailNilai = json_decode($value->detail);   
                $total = [];          
               for ($x=1; $x < $tanggal+1; $x++) {
                   foreach ($detailNilai as $key => $value) {
                       $tanggalAbsen = date("d",strtotime($value->tanggal));
                       if ($x==$tanggalAbsen) {
                           $absen=get_absen($value->jns_absen);
                           if(empty($total[$value->jns_absen])){
                               $total[$value->jns_absen]=1;
                           }else{
                               $total[$value->jns_absen] = $total[$value->jns_absen]+1;
                           }
                           break;
                       }else{
                           $absen="";
                       }
                   }
                   echo "<td>$absen</td>";                   
               }
               foreach (get_absen() as $key => $rs) {
                   if($rs['id'] > 0) {
                       if (!empty($total[$rs["id"]])){
                           $nilai = $total[$rs["id"]];
                       }else{
                           $nilai = 0;
                       }
                       echo "<td>$nilai</td>";
                   }
               } 
>>>>>>> 4f229f012e9d0a8a07e312b74becd22a91ed6ff9
            }
        ?>
    </tbody>
</table>
