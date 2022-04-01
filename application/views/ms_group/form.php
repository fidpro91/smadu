    <div class="col-md-12">
      			<?=form_open("ms_group/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_group"],$model)?>
		<?=form_hidden("group_id")?>
			<?=create_input("group_code")?>
			<?=create_input("group_name")?>
			<?=create_input("group_active")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_group').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_group").hide();
		$("#form_ms_group").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>