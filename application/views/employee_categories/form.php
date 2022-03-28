    <div class="col-md-12">
      			<?=form_open("employee_categories/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_employee_categories"],$model)?>
			<?=create_input("empcat_code")?>
			<?=create_input("empcat_name")?>			
			<?= create_select([
					"attr" => ["name" => "empcat_active=status", "id" => "empcat_active", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non Aktif"]],
			]) ?>
		<?=form_hidden("empcat_id")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_employee_categories').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_employee_categories").hide();
		$("#form_employee_categories").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>