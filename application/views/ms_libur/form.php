<style>
	 #libur_hari {
		display: none;
	}
</style>
<div class="col-md-12">
	<?= form_open("ms_libur/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_ms_libur"], $model) ?>
	<?= form_hidden("id_libur") ?>
	<?= create_select(["attr" => ["name" => "reff_id=Definisi Libur", "id" => "reff_id", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => $this->setting->kategori_libur]],
				"column"  => ["reff_id", "reff_name"]
			],
	]) ?>
	<?= create_select([
			"attr" => ["name" => "perulangan_libur=frekuensi libur", "id" => "perulangan_libur", "class" => "form-control", 'required' => true],
			"option" => [
					["id" => '1', "text" => "Sehari"],
					["id" => '2', "text" => "Mingguan"]
			]
	]) ?>
	<div id="libur_hari">
		<?= create_select([
			"attr" => ["name" => "hari", "id" => "hari", "class" => "form-control"],
			"option" => get_hari()
		])
		?>
	</div>
	<div id="libur_tanggal">
		<?= create_inputDate("tanggal=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
	</div>
	<?= create_select([
			"attr" => ["name" => "libur_type=diperuntukkan", "id" => "libur_type", "class" => "form-control", 'required' => true],
			"option" => [
					["id" => '1', "text" => "Siswa"],
					["id" => '2', "text" => "Pegawai"],
					["id" => '3', "text" => "Siswa & Pegawai"]
			]
	]) ?>
	<?= create_input("libur_tahun") ?>
	<?= create_textarea("keterangan") ?>
	<?= form_close() ?>
	<div class="row panel-footer" align="center">
		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_libur').submit()">Save</button>
		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">
	$("#btn-cancel").click(() => {
		$("#form_ms_libur").hide();
		$("#form_ms_libur").html('');
	});
	$(document).ready(()=>{
		$("#perulangan_libur").trigger("change");	
	})
	$("#perulangan_libur").change(function(){
		if ($(this).val() == 1) {
			$("#hari").val(null);
			$("#libur_tanggal").show();
			$("#libur_hari").hide();
		}else{
			$("#tanggal").val(null);
			$("#libur_tanggal").hide();
			$("#libur_hari").show();
		}
	})
	<?= $this->config->item('footerJS') ?>
</script>