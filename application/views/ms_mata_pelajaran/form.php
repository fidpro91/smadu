    <div class="col-md-12">
      			<?=form_open("ms_mata_pelajaran/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_mata_pelajaran"],$model)?>
			<?=create_input("mata_pelajaran")?>
			<?=create_input("is_active")?>
			<?=create_input("kode_mp")?>
			<?=create_input("klasifikasi_mp")?>
		<?=form_hidden("id_mp")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_mata_pelajaran').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_mata_pelajaran").hide();
		$("#form_ms_mata_pelajaran").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>