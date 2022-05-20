<div class="col-md-12">
      			<?=form_open("ms_siswa/save",["method"=>"post","id"=>"fm_ms_siswa","enctype"=>"multipart/form-data"],$model)?>
				  <div class="row">

 <?=form_hidden("st_id")?>
 <?=form_hidden("finger_id")?>

 <?= form_fieldset('BIODATA'); ?>	
 <div class="col-md-6">		
			<?=create_input("st_nis=NIS (Nomor Induk Siswa)")?>			
			<?=create_input("st_name=Nama Siswa")?>
			<?=create_input("st_father=Ayah")?>			
			<?= create_select([
					"attr" => ["name" => "st_sex=Jenis Kelamin", "id" => "st_sex", "class" => "form-control", 'required' => true],
					"option" => [["id" => 'L', "text" => "Laki-Laki"], ["id" => 'P', "text" => "Perempuan"]],
			]) ?>
			<?=create_input("st_born=Tempat Lahir")?>			
</div>
<div class="col-md-6">
			<?=create_input("st_nokk=NO KK")?>
			<?=create_input("st_phone=Telepon",)?>
			<?=create_input("st_mother=Ibu")?>			
			<?= create_select(["attr" => ["name" => "religion_id=Agama", "id" => "religion_id", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => $this->setting->agama]],
				"column"  => ["reff_id", "reff_name"]
			],
			]) ?>				
			<?= create_inputDate("st_birthdate=Tanggal Lahir", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
</div>
<?= form_fieldset_close(); ?>
<?= form_fieldset(''); ?>

		<div class="col-md-3">
		<?= create_select([
					"attr" => ["name" => "st_active=Status", "id" => "st_active", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>			
		</div>
		<div class="col-md-3">						
			<?=create_input("st_email=Email")?>
		</div>
		<div class="col-md-3">
			<?=create_input("st_th_masuk=Tahun Masuk")?>
		</div>
		<div class="col-md-3">		
		<?= create_select(["attr" => ["name" => "last_kelas=Kelas Terakhir", "id" => "last_kelas", "class" => "form-control"],
			"model" =>[
				"m_ms_unit" => ["get_ms_unit", ["unit_type" => $this->setting->last_class]],
				"column"  => ["unit_id", "unit_name"]
			],
			]) ?>	
		</div>
		<div class="col-md-12" >
			
			<label>Foto Siswa</label>
					<input type="file" name="photo" id="photo">	
			<label>Max 1 mb</label>
				
		</div>
<?= form_fieldset_close(); ?>

<?= form_fieldset('ALAMAT SISWA'); ?>
		<div class="col-md-3">		
		<?= create_select2([
					"attr" => ["name" => "st_prov=provinsi", "id" => "st_prov","required"=> true, "class" => "form-control", "onchange" => "get_reg('st_city',this.value)"],
					"model" => [
							"m_ms_region" => ["get_ms_region", ["reg_level" => $this->setting->reg_level]],
							"column" => ["reg_code", "reg_name"]
					],
			]) ?>
		</div>
		<div class="col-md-3">				
			<?= create_select2([
					"attr" => ["name" => "st_city=kabupaten", "id" => "st_city", 'required' => true, "class" => "form-control", "onchange" => "get_reg('st_district',this.value)"],
			]) ?>
		</div>
		<div class="col-md-3">			
		<?= create_select2([
					"attr" => ["name" => "st_district=Kecamatan", "id" => "st_district", 'required' => true, "class" => "form-control", "onchange" => "get_reg('st_resident',this.value)"],
			]) ?>
		</div>
		<div class="col-md-3">
		<?= create_select2([
					"attr" => ["name" => "st_resident=desa", "id" => "st_resident", "class" => "form-control", 'required' => true],
			]) ?>	
		</div>
		<div class="col-md-12">
		<?=create_textarea("st_address=Alamat Lengkap")?>		
		</div>	
			

			
<?= form_fieldset_close(); ?>
<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_siswa').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_ms_siswa").hide();
		$("#form_ms_siswa").html('');
	});
	function get_reg(dest, id) {
		$("#" + dest + " > option").remove();
		const setData = $.get("employee/get_region/" + id, (resp) => {
			$("#" + dest + "").append(resp); 
		});
		return setData;
	}

  <?=$this->config->item('footerJS')?>
</script>