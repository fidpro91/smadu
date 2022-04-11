<div class="col-md-12">
	<?= form_open("jam_kerja_harian/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_jam_kerja_harian"], $model) ?>
		<?= form_hidden("id") ?>
		<?= create_select([
			"attr" => ["name" => "hari", "id" => "hari", "class" => "form-control"],
			"option" => get_hari()
		])
		?>
		<?=create_inputmask("jam_masuk",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?= create_input("toleransi_keterlambatan") ?>
		<?=create_inputmask("jam_istirahat",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?=create_inputmask("jam_pulang",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?= create_select([
				"attr" => ["name" => "jadwal_untuk", "id" => "jadwal_untuk", "class" => "form-control", 'required' => true],
				"option" => [["id" => '1', "text" => "Pegawai"], ["id" => '2', "text" => "Siswa"]],
		]) ?>
		<?= create_textarea("keterangan") ?>
		<?= form_close() ?>
	<div class="row panel-footer" align="center">
		<button class="btn btn-primary" type="button" onclick="$('#fm_jam_kerja_harian').submit()">Save</button>
		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">
	$("#btn-cancel").click(() => {
		$("#form_jam_kerja_harian").hide();
		$("#form_jam_kerja_harian").html('');
	});

	<?= $this->config->item('footerJS') ?>
</script>