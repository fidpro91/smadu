    <div class="col-md-12">
      			<?=form_open("ms_region/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_region"],$model)?>
		<?=form_hidden("reg_code")?>
			<?=create_input("reg_name")?>
			<?=create_input("reg_level")?>
			<?=create_input("reg_parent")?>
			<?=create_input("reg_active")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_region').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_region").hide();
		$("#form_ms_region").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>