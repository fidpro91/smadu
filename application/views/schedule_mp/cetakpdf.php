<?php $action = null;
//echo count($mataKuliah);
//die();
if ($action != 'excel') { ?>
<!-- <table  >
		<tr>
			<td><img src="<?= base_url() ?>assets/images/icon/logo_du.png" style="width: 25%" alt=""></td>
			<td >
				<h4>JADWAL MATA PELAJARAN</h4>
				<h4><?= $smadu->nama_instansi ?></h4>
			</td>
			<td>
				<p><?= $smadu->alamat_instansi ?></p>
				<p><?= $smadu->status_akreditasi ?>, <?= $smadu->tanggal_akreditasi ?>,</p>
				 <p><?= $samdu->universitas_city . " " . $smadu->universitas_city . " " . $smadu->universitas_phone ?>
				<p>e-mail :<?= $smadu->email ?></p>
				<p>website :<?= $smadu->website ?></p>
			</td>
		</tr>
	</table> -->

	<table width="100%"  cellspacing="0" cellpadding="0" border="0" class="tabel"  style="font-size: 12px">
    	<tr>
		<td  style="width:10%" align="left"><img src="<?= base_url() ?>assets/images/icon/logo_du.png" style="width: 65%" alt=""></td>
    		<td  align="center" style="font-size: 14px;width:60%"><strong>
				JADWAL MATA PELAJARAN                
                </strong> <br> <b><?= $smadu->nama_instansi ?></b><br>								
				<?= $smadu->alamat_instansi ."<br>"."e-mail :". $smadu->email ."<br>"."website :". $smadu->website."<br>"."phone :". $smadu->no_telp?>
				
			</td>			
    	</tr>
    </table>
<?php } ?>
<hr>
<table border="1" width="100%" style="border-collapse: collapse;text-align: center">
	<tr>
		<td>No</td>
        <td>Mata Pelajaran</td>
        <td>Jam Mulai</td>
        <td>Jam Selesai</td>
        <td>Dosen</td>
        <td>Kelas</td>
	</tr>

	
	<?php
	$no = 1;
	foreach ($dataMapel as $key) { ?>
		<tr>
			<td><?= $no++; ?></td>
			<td><?= $key->mata_pelajaran; ?></td>
			<td><?= $key->start_time; ?></td>
            <td><?= $key->finish_time; ?></td>
            <td><?= $key->emp_name; ?></td>
            <td><?= $key->unit_name; ?></td>	

		</tr>
	<?php }
	?>
</table>

