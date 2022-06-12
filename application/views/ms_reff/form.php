    <div class="col-md-12">
      			<?=form_open("ms_reff/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_reff"],$model)?>
		<?=form_hidden("reff_id")?>
			<?=create_input("reff_code")?>
			<?=create_input("reff_name")?>			
			<?= create_select(["attr" => ["name" => "reff_active=Status", "id" => "reff_active", "class" => "form-control",'required' => true],
			 "option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>
			<?= create_select(["attr" => ["name" => "refcat_id=Kategori Reff", "id" => "refcat_id", "class" => "form-control"],
			"model" => ["m_ms_reff_cat" => "get_ms_reff_cat", "column" => ["refcat_id", "refcat_name"]]
			]) ?>
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