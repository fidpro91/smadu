    <div class="col-md-12">
      			<?=form_open("ms_reff/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_reff"],$model)?>
		<?=form_hidden("reff_id")?>
			<?=create_input("reff_code")?>
			<?=create_input("reff_name")?>
			<?=create_input("reff_active")?>
			<?=create_input("refcat_id")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_reff').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_reff").hide();
		$("#form_ms_reff").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>