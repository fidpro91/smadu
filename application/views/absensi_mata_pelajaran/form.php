<div class="col-md-12">
	<?= form_open("absensi_mata_pelajaran/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_absensi_mata_pelajaran"], $model) ?>
		<?= form_hidden("id") ?>
		<?= form_hidden("schedule_id") ?>
		<?= form_hidden("user_id") ?>
		<?= form_hidden("mp_id") ?>
		<?= create_inputDate("absen_date=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
		<?= create_input("mata_pelajaran") ?>
		<?=create_inputmask("check_in_at=masuk",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?=create_inputmask("check_out_at=keluar",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?= create_select([
			"attr" => ["name" => "absen_type", "id" => "absen_type", "class" => "form-control"],
			"option" => get_absen()
		])
		?>
		<?= create_select([
				"attr" => ["name" => "is_verified=Verifikasi", "id" => "is_verified", "class" => "form-control", 'required' => true],
				"option" => [["id" => 't', "text" => "Ya"], ["id" => 'f', "text" => "Tidak"]],
		]) ?>	
	<?= form_close() ?>
	<div class="row panel-footer" align="center">
		<button class="btn btn-primary" type="button" onclick="$('#fm_absensi_mata_pelajaran').submit()">Save</button>
		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">
	$("#btn-cancel").click(() => {
		$("#form_absensi_mata_pelajaran").hide();
		$("#form_absensi_mata_pelajaran").html('');
	});
	$("body").on("focus", "#mata_pelajaran", function() {
        $(this).autocomplete({
            source: "<?php echo site_url('Absensi_mata_pelajaran/get_mata_pelajaran'); ?>/" + $("#class_id").val(),
            select: function(event, ui) {
                $('#mp_id').val(ui.item.id_mp);
            }
        });
    });
	<?= $this->config->item('footerJS') ?>
</script>