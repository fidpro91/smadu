    <div class="col-md-12">
      			<?=form_open("user_activity/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_user_activity"],$model)?>
		<?=form_hidden("id")?>
			<?=create_input("user_id")?>
			<?=create_input("act_date")?>
			<?=create_input("keterangan")?>
			<?=create_input("act_data")?>
<?=form_close()?>
      <div class="row panel-footer" align="center">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_user_activity').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_user_activity").hide();
		$("#form_user_activity").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>