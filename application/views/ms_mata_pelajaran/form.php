    <div class="col-md-12">
      			<?=form_open("ms_mata_pelajaran/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_ms_mata_pelajaran"],$model)?>
			<?=create_input("mata_pelajaran")?>
			<?=create_input("kode_mp")?>
			<?= create_select(["attr" => ["name" => "klasifikasi_mp= Kategori Mata Pelajaran", "id" => "klasifikasi_mp", "class" => "form-control"],
			"model" => ["m_ms_klasifikasi_mp" => "get_ms_klasifikasi_mp", "column" => ["klas_mk_id", "klas_mk_nama"]]
			]) ?>
			<?= create_select(["attr" => ["name" => "is_active=Status", "id" => "is_active", "class" => "form-control",'required' => true],
			 "option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>
			
		<?=form_hidden("id_mp")?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_mata_pelajaran').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_mata_pelajaran").hide();
		$("#form_ms_mata_pelajaran").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>