<?= form_open("schedule_mp/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_schedule_mp"], $model) ?>
<div class="col-md-3">
    <?= create_select2([
            "attr" => ["name" => "class_id=Kelas", "id" => "class_id", "class" => "form-control", 'required' => true],
            "model" => [
                    "m_ms_unit" => "get_unit_kelas",
                    "column" => ["unit_id", "unit_name"]
            ],
    ]) ?>
    <?= create_select([
        "attr" => ["name" => "semester_id", "id" => "semester_id", "class" => "form-control"],
        "option" => get_semester()
    ])
    ?>
    <?= create_input("tahun_pelajaran") ?>
</div>
<div class="col-md-9">
    <div class="div_detil"></div>
</div>
<div class="row col-md-12">
    <div class="panel-footer" align="center">
        <button class="btn btn-primary" type="button" onclick="$('#fm_schedule_mp').submit()">Save</button>
        <button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
    </div>
</div>
<?= form_close() ?>
<script type="text/javascript">
    $("#btn-cancel").click(() => {
        $("#form_schedule_mp").hide();
        $("#form_schedule_mp").html('');
        $("#data_schedule_mp").show();
    });

    $(document).ready(() => {
        $(".div_detil").inputMultiRow({
            column: () => {
                var dataku;
                $.ajax({
                    'async': false,
                    'type': "GET",
                    'dataType': 'json',
                    'url': "schedule_mp/get_multiRows",
                    'success': function(data) {
                        dataku = data;
                    }
                });
                return dataku;
            }
        });
    });
    $("body").on("focus", ".start_time, .finish_time", function() {
        $(this).inputmask("datetime", {
            "placeholder": "00:00:00",
            'inputFormat': 'HH:MM:ss'
        });
    });
    $("body").on("focus", ".autocom_mp_id", function(e) {
        if ($("#class_id").val() <= 0) {
            alert("Mohon di isikan prodi terlebih dahulu");
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        }
        $(this).autocomplete({
            source: "<?php echo site_url('schedule_mp/get_mata_pelajaran'); ?>/" + $("#class_id").val(),
            select: function(event, ui) {
                $(this).closest('tr').find('.mp_id').val(ui.item.id_mp);
            }
        });
    });
    <?= $this->config->item('footerJS') ?>
</script>