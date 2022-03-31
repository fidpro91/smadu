    <div class="col-md-12">
      			<?=form_open("ms_klasifikasi_mp/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_klasifikasi_mp"],$model)?>
		<?=form_hidden("klas_mk_id")?>
			<?=create_input("klas_mk_kode")?>
			<?=create_input("klas_mk_nama")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_klasifikasi_mp').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_klasifikasi_mp").hide();
		$("#form_ms_klasifikasi_mp").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>