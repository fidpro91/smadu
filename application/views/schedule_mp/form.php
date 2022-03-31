    <div class="col-md-12">
      			<?=form_open("schedule_mp/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_schedule_mp"],$model)?>
			<?=create_input("mp_id")?>
			<?=create_input("guru_id")?>
			<?=create_input("day")?>
			<?=create_input("start_time")?>
			<?=create_input("class_id")?>
			<?=create_input("set_by")?>
			<?=create_input("set_on")?>
			<?=create_input("finish_time")?>
			<?=create_input("tahun_pelajaran")?>
			<?=create_input("is_active")?>
		<?=form_hidden("schedule_id")?>
			<?=create_input("closed_at")?>
			<?=create_input("closed_by")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_schedule_mp').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_schedule_mp").hide();
		$("#form_schedule_mp").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>