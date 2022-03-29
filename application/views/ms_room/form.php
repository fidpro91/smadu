    <div class="col-md-12">
      			<?=form_open("ms_room/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_room"],$model)?>
		<?=form_hidden("room_id")?>
			<?=create_input("room_code=kelas kode")?>
			<?=create_input("kelas")?>
			<?=create_input("room_name=nama kelas")?>
			<?=create_input("capacity")?>
			<?=create_input("room_active")?>
			<?= create_select([
					"attr" => ["name" => "room_active=Status", "id" => "room_active", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non Aktif"]],
			]) ?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_room').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_room").hide();
		$("#form_ms_room").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>