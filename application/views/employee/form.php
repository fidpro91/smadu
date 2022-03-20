    <div class="col-md-12">
      			<?=form_open("employee/save",["method"=>"post","id"=>"fm_employee"],$model)?>
		<?=form_hidden("emp_id")?>
		<div class="row">
    		<?= form_fieldset('BIODATA'); ?>
			<div class="col-md-4">
			<?=create_input("emp_no")?>
			<?=create_input("emp_noktp")?>
			<?=create_input("emp_nokk")?>
			<?=create_input("emp_name")?>
			<?= create_select([
					"attr" => ["name" => "emp_sex=Jenis Kelamin", "id" => "emp_sex", "class" => "form-control", 'required' => true],
					"option" => [["id" => 'L', "text" => "Laki-Laki"], ["id" => 'P', "text" => "Perempuan"]],
			]) ?>
		</div>
		<div class="col-md-4">
			<?=create_input("emp_birthdate")?>
			<?= create_select([
					"attr" => ["name" => "emp_status=Status Pegawai", "id" => "emp_status", "class" => "form-control", 'required' => true],
					"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
			]) ?>
			<?=create_input("emp_couple")?>
			<?=create_input("emp_phone")?>
			
			<?= create_inputDate("tahun_masuk=Tahun Masuk", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
			
		</div>	
		<div class="col-md-4">
			<?=create_input("absen_code")?>
			<?=create_input("emp_photo")?>
			<?=create_input("tanggal_keluar")?>	
			<?=create_input("alamat_domisili")?>
			
			
		</div>
		<?= form_fieldset_close(); ?>
		<?= form_fieldset('KELENGKAPAN'); ?>
		<div class="col-md-4">
			<?=create_input("emp_npwp")?>			
			<?=create_input("unit_id")?>
			<?=create_input("position_id")?>
		</div>
		<div class="col-md-4">
			<?=create_input("agama")?>
			<?=create_input("pendidikan")?>
			<?=create_input("emp_active")?>
		</div>
		<div class="col-md-4">
			<?=create_input("emp_born")?>
			<?=create_input("emp_mail")?>
			<?=create_input("emp_type")?>
		</div>
		
		<?= form_fieldset_close(); ?>
		<?= form_fieldset('ALAMAT'); ?>
		<div class="col-md-3">			
			<?=create_input("emp_resident")?>
		</div>
		<div class="col-md-3">			
			<?=create_input("emp_district")?>
		</div>
		<div class="col-md-3">			
			<?=create_input("emp_city")?>
		</div>
		<div class="col-md-3">
		<?=create_input("emp_prov")?>			
		</div>
		<div class="col-md-3" align="center">
		<?=create_input("emp_address")?>		
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

  <?=$this->config->item('footerJS')?>
</script>