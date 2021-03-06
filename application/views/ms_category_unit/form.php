<div class="col-md-12">
	<?= form_open("ms_category_unit/save", ["method" => "post", "id" => "fm_ms_category_unit"], $model) ?>
	<div class="row">
		<?= form_hidden("catunit_id") ?>
		<div class="col-md-12">
			<?= create_input("kode") ?>
			<?= create_input("nama") ?>
			<?= create_input("no_sk=NO SK") ?>
			<?= create_inputDate("tanggal_sk=Tanggal SK", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			<?= create_select([
				"attr" => ["name" => "status=Status", "id" => "status", "class" => "form-control"],
				"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non Aktif"]],
			]) ?>
		</div>
	</div>
	<?= form_close() ?>
	<div class="panel-footer">
		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_category_unit').submit()">Save</button>
		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">
	$("#btn-cancel").click(() => {
		$("#form_ms_category_unit").hide();
		$("#form_ms_category_unit").html('');
	});
	<?= $this->config->item('footerJS') ?>
</script>