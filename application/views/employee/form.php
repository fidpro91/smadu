    <div class="col-md-12">
      			<?=form_open("employee/save",["method"=>"post","id"=>"fm_employee","enctype"=>"multipart/form-data"],$model)?>
		<?=form_hidden("emp_id")?>
		<div class="row">
    		<?= form_fieldset('BIODATA'); ?>
			<div class="col-md-4">
			<?=create_input("emp_no=No Pegawai")?>
			<?=create_input("emp_noktp=No KTP")?>
			<?=create_input("emp_nokk=No KK")?>
			<?=create_input("emp_name= nama")?>
			<?= create_select([
					"attr" => ["name" => "emp_sex=Jenis Kelamin", "id" => "emp_sex", "class" => "form-control", 'required' => true],
					"option" => [["id" => 'L', "text" => "Laki-Laki"], ["id" => 'P', "text" => "Perempuan"]],
			]) ?>
		</div>
		<div class="col-md-4">			
			<?= create_inputDate("emp_birthdate=Tanggal Lahir", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			<?=create_input("emp_born=Tempat Lahir")?>			
			<?=create_input("emp_couple=Nama Suami/Istri")?>		
			<?=create_input("emp_phone=Telepon")?>			
			<?= create_inputDate("tahun_masuk=Tahun Masuk", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			
		</div>	
		<div class="col-md-4">
			<?=create_input("absen_code=Kode absen")?>
			
			<div class="form-group">
					<label>Foto Pegawai</label>
					<input type="file" name="emp_photo" id="emp_photo">
				</div>			
			<?= create_inputDate("tanggal_keluar=Tanggal Keluar", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			<?=create_textarea("alamat_domisili=Alamat Domisili")?>
			<?= create_select(["attr" => ["name" => "empcat_id=Kategori", "id" => "empcat_id", "class" => "form-control", 'required' => true],
			"model" => ["m_employee_categories" => "get_employee_categories", "column" => ["empcat_id", "empcat_name"]]
			]) ?>
			
		</div>
		<?= form_fieldset_close(); ?>
		<?= form_fieldset('KELENGKAPAN'); ?>
		<div class="col-md-4">
			<?=create_input("emp_npwp=NPWP")?>			
			<?= create_select(["attr" => ["name" => "unit_id=Tempat Ruangan", "id" => "unit_id", "class" => "form-control"],
			"model" => ["m_ms_unit" => "get_unit", "column" => ["unit_id", "unit_name"]]
			]) ?>
			
			<?= create_select(["attr" => ["name" => "position_id=Jabatan", "id" => "position_id", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => '5']],
				"column"  => ["reff_id", "reff_name"]
			],
			]) ?>
		</div>
		<div class="col-md-4">
			<?= create_select(["attr" => ["name" => "agama=Agama", "id" => "agama", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => '1']],
				"column"  => ["reff_id", "reff_name"]
			],
			]) ?>
			<?= create_select(["attr" => ["name" => "pendidikan=Pendidikan", "id" => "pendidikan", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => '2']],
				"column"  => ["reff_id", "reff_name"]
			],
			]) ?>		
			<?= create_select([
					"attr" => ["name" => "emp_active=Status Pegawai", "id" => "emp_active", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>
		</div>
		<div class="col-md-4">	
			<?= create_select(["attr" => ["name" => "emp_status=Status Perkawinan", "id" => "emp_status", "class" => "form-control"],
			"model" =>[
				"m_ms_reff" => ["get_ms_reff", ["refcat_id" => '4']],
				"column"  => ["reff_id", "reff_name"]
			],
			]) ?>	
			<?=create_input("emp_mail=Email")?>
			<?= create_select([
					"attr" => ["name" => "emp_type=Tipe", "id" => "emp_type", "class" => "form-control", 'required' => true],
					"option" => [["id" => '1', "text" => "Shift"], ["id" => '2', "text" => "Non Shift"]],
			]) ?>
		</div>
		
		<?= form_fieldset_close(); ?>
		<?= form_fieldset('ALAMAT KTP'); ?>
		<div class="col-md-3">			
			<?= create_select2([
					"attr" => ["name" => "emp_prov=provinsi", "id" => "emp_prov", 'required' => true, "class" => "form-control", "onchange" => "get_reg('emp_city',this.value)"],
					"model" => [
							"m_ms_region" => ["get_ms_region", ["reg_level" => '1']],
							"column" => ["reg_code", "reg_name"]
					],
			]) ?>
		</div>
		<div class="col-md-3">				
			<?= create_select2([
					"attr" => ["name" => "emp_city=kabupaten", "id" => "emp_city", 'required' => true, "class" => "form-control", "onchange" => "get_reg('emp_district',this.value)"],
			]) ?>
		</div>
		<div class="col-md-3">			
		<?= create_select2([
					"attr" => ["name" => "emp_district=Kecamatan", "id" => "emp_district", 'required' => true, "class" => "form-control", "onchange" => "get_reg('emp_resident',this.value)"],
			]) ?>
		</div>
		<div class="col-md-3">
		<?= create_select2([
					"attr" => ["name" => "emp_resident=desa", "id" => "emp_resident", "class" => "form-control", 'required' => true],
			]) ?>	
		</div>
		<div class="col-md-6">
		<?=create_textarea("emp_address=Alamat Lengkap")?>		
		</div>
		<?= form_fieldset_close(); ?>
		<?=form_close()?>
      <div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_employee').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>	
    </div>
	
<script type="text/javascript">
	$("#btn-cancel").click( () => {
		$("#form_employee").hide();
		$("#form_employee").html('');
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