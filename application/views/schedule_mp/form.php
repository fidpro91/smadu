<style>
	.select2-drop {z-index: 99999;}
</style>
<div class="col-md-12">
	<?= form_open("schedule_mp/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_schedule_mp"], $model) ?>
	<?= form_hidden("schedule_id") ?>
	<?= form_hidden("mp_id") ?>
	<?= create_input("mata_pelajaran") ?>
	<?= create_select2([
            "attr" => ["name" => "guru_id=guru pengajar", "id" => "guru_id", "class" => "form-control", 'required' => true],
            "model" => [
                    "m_employee" => "get_employee",
                    "column" => ["emp_id", "emp_name"]
            ],
    ]) ?>
	<?= create_select([
        "attr" => ["name" => "day=hari", "id" => "day", "class" => "form-control"],
        "option" => get_hari()
    ])
    ?>
	<?= create_input("start_time") ?>
	<?= create_input("finish_time") ?>
	<?= create_select2([
            "attr" => ["name" => "class_id=Kelas", "id" => "class_id", "class" => "form-control", 'required' => true],
            "model" => [
                    "m_ms_unit" => ["get_ms_unit", ["unit_type" => $this->setting->kategori_kelas]],
                    "column" => ["unit_id", "unit_name"]
            ],
    ]) ?>
	<?= create_input("tahun_pelajaran") ?>
	<?= create_select([
        "attr" => ["name" => "semester_id", "id" => "semester_id", "class" => "form-control"],
        "option" => get_semester()
    ])
    ?>
	<?= create_select([
			"attr" => ["name" => "is_active=Status", "id" => "is_active", "class" => "form-control", 'required' => true],
			"option" => [["id" => 't', "text" => "Aktif"], ["id" => 'f', "text" => "Non AKtif"]],
	]) ?>
	<?= form_close() ?>
	<div class="row panel-footer">
		<button class="btn btn-primary" type="button" onclick="$('#fm_schedule_mp').submit()">Save</button>
		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(()=>{
		$('#start_time, #finish_time').inputmask("datetime", {
            "placeholder": "00:00:00",
            'inputFormat': 'HH:MM:ss'
        });
	})
	$("#btn-cancel").click(() => {
		$("#modal_content > .modal-body").html('');
		$("#modal_content").modal('hide');
	});

	$("body").on("focus", "#mata_pelajaran", function() {
        $(this).autocomplete({
            source: "<?php echo site_url('schedule_mp/get_mata_pelajaran'); ?>/" + $("#class_id").val(),
            select: function(event, ui) {
                $('#mp_id').val(ui.item.id_mp);
            }
        });
    });

	$("#fm_schedule_mp").submit(()=>{
		$.post('schedule_mp/update', $("#fm_schedule_mp").serialize(), (resp) => {
			if (resp.code == '200') {
				toastr.success(resp.message, "Message : ");
				toastr.options.onHidden=setTimeout(() => {
					location.reload()
				}, 2000);
			} else {
				toastr.error(resp.message, "Message : ");
			}
		}, 'json');
		return false;
	})
	<?= $this->config->item('footerJS') ?>
</script>