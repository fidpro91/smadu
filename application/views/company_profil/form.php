    <div class="col-md-12">
      			<?=form_open("company_profil/save",["method"=>"post","id"=>"fm_company_profil","enctype"=>"multipart/form-data"],$model)?>
		<?=form_hidden("id")?>
		<div class="row">
			<div class="col-md-6">
			<?=create_input("kode_instansi")?>
			<?=create_input("nama_instansi")?>
			<?=create_input("alamat_instansi")?>
			<?=create_input("no_telp")?>
			<?=create_input("email")?>
			<?=create_input("website")?>			
			</div>
			<div class="col-md-6">
			<?=create_input("no_sk")?>			
			<?= create_inputDate("tanggal_berdiri=Tanggal Berdiri", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>			
			<?= create_inputDate("tanggal_akreditasi=Tanggal Berdiri", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			<?=create_input("status_akreditasi")?>
			<?=create_input("kepala_instansi")?>
			<div class="form-group">
			<label>LOGO INSTANSI</label>
			<input type="file" name="logo1" id="logo1">
			</div>
			<!-- <?=create_input("logo2")?>
			<?=create_input("logo3")?> -->
		</div>
</div>
<?=form_close()?>
      <div class="row panel-footer" align="center">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_company_profil').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_company_profil").hide();
		$("#data_company_profil").show();
		$("#form_company_profil").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>