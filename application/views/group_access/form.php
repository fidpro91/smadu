    <div class="col-md-12">
      			<?=form_open("group_access/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_group_access"],$model)?>
			<?=create_input("group_id")?>
			<?=create_input("menu_id")?>
			<?=create_input("access_view")?>
			<?=create_input("access_write")?>
		<?=form_hidden("id")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_group_access').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_group_access").hide();
		$("#form_group_access").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>