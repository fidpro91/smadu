    <div class="col-md-12">
      			<?=form_open("absensi_pegawai/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_absensi_pegawai"],$model)?>
		<?=form_hidden("absen_id")?>
			<?=create_input("emp_absen_code")?>
			<?= create_inputDate("st_birthdate=Tanggal Lahir", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			<?=create_input("absen_date")?>
			<?=create_input("check_in")?>
			<?=create_input("check_out")?>
			<?=create_input("late_duration")?>
			<?=create_input("absen_type")?>
			<?=create_input("user_created")?>
			<?=create_input("created_at")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_absensi_pegawai').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_absensi_pegawai").hide();
		$("#form_absensi_pegawai").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>