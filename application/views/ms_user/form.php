    <div class="col-md-12">
    	<?= form_open("ms_user/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_ms_user"], $model) ?>
        <?= form_hidden("emp_id") ?>
    	<?= create_input("user_name") ?>
    	<?= create_input("user_password") ?>
    	<?= form_hidden("user_id") ?>
    	<?= create_select([
			"attr" => ["name" => "user_status=Status", "id" => "user_status", "class" => "form-control"],
			"option" => [
				["id" => "t", "text" => "AKTIF"], ["id" => "f", "text" => "Non Aktif"]
			]
		]) ?>
    	<?= create_input("person_name=nama") ?>
    	<?= create_select([
			"attr" => ["name" => "user_group=Group User", "id" => "user_group", "class" => "form-control"],
			"model" => ["M_ms_group" => "get_ms_group", "column" => ["group_id", "group_name"]]
		]) ?>
		<?= create_select2([
			"attr" => ["name" => "siswa_id[]=Wali dari siswa", "id" => "siswa_id", "class" => "form-control", "multiple" => "true"],
			"model" => ["m_ms_siswa" => "get_ms_siswa3", "column" => ["st_id", "nama_siswa"]]
		]) ?>
    	<?= form_close() ?>
    	<div class="panel-footer">
    		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_user').submit()">Save</button>
    		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
    	</div>
    </div>
    <script type="text/javascript">
    	$("#btn-cancel").click(() => {
    		$("#form_ms_user").hide();
    		$("#form_ms_user").html('');
    	});

    	$("body").on("focus", "#person_name", function() {
    		$(this).autocomplete({
    			source: "<?php echo site_url('ms_user/get_employee/person_name'); ?>",
    			select: function(event, ui) {
    				$('#person_name').val(ui.item.employee_name),
					$('#emp_id').val(ui.item.emp_id);
    			}
    		});

    	});

    	<?= $this->config->item('footerJS') ?>
    </script>