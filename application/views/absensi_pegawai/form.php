    <div class="col-md-12">
    	<?= form_open("absensi_pegawai/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_absensi_pegawai"], $model) ?>
    	<?= form_hidden("absen_id") ?>
    	<?= form_hidden("emp_id") ?>
    	<?= create_input("emp_name=nama pegawai") ?>
		<?= create_inputDate("absen_date=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
		<?=create_inputmask("check_in=masuk",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
		<?=create_inputmask("check_out=keluar",['datetime', ['inputFormat'=>'HH:MM:ss',"placeholder"=>"00:00:00"]])?>
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
    		<button class="btn btn-primary" type="button" onclick="$('#fm_absensi_pegawai').submit()">Save</button>
    		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
    	</div>
    </div>
    <script type="text/javascript">
    	$("#btn-cancel").click(() => {
    		$("#form_absensi_pegawai").hide();
    		$("#form_absensi_pegawai").html('');
    	});
		$("body").on("focus", "#emp_name", function() {
			$(this).autocomplete({
				source: "<?php echo site_url('employee/get_employee'); ?>",
				select: function(event, ui) {
					$('#emp_id').val(ui.item.emp_id);
				}
			});
		});
    	<?= $this->config->item('footerJS') ?>
    </script>