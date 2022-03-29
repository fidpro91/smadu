    <div class="col-md-12">
      			<?=form_open("ms_unit/save",["method"=>"post","enctype"=>"multipart/form-data","class"=>"form-horizontal","id"=>"fm_ms_unit"],$model)?>
		<?=form_hidden("unit_id")?>
		<?= form_hidden("emp_id") ?>		
			<?=create_input("unit_code=Kode")?>
			<?=create_input("unit_name=Nama Unit")?>
			<?=create_input("pj_unit=Penanggung Jawab")?>
			
			<?= create_select([
					"attr" => ["name" => "unit_active=Status", "id" => "unit_active", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>
		<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_unit').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_unit").hide();
		$("#form_ms_unit").html('');
	});



	


  <?=$this->config->item('footerJS')?>
</script>