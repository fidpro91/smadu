    <div class="col-md-12">
      			<?=form_open("company_profil/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_company_profil"],$model)?>
		<?=form_hidden("id")?>
			<?=create_input("kode_instansi")?>
			<?=create_input("nama_instansi")?>
			<?=create_input("alamat_instansi")?>
			<?=create_input("no_telp")?>
			<?=create_input("email")?>
			<?=create_input("website")?>
			<?=create_input("kepala_instansi")?>
			<?=create_input("no_sk")?>
			<?=create_input("tanggal_berdiri")?>
			<?=create_input("status_akreditasi")?>
			<?=create_input("tanggal_akreditasi")?>
			<?=create_input("logo1")?>
			<?=create_input("logo2")?>
			<?=create_input("logo3")?>
<?=form_close()?>
      <div class="row panel-footer" align="center">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_company_profil').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_company_profil").hide();
		$("#form_company_profil").html('');
	});

  <?=$this->config->item('footerJS')?>
</script>