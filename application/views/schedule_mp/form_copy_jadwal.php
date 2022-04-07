<?= form_open("", ["method" => "post", "id" => "fm_copy_mp"]) ?>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Asal Penjadwalan</h3>
            </div>
            <div class="panel-body">
                <?= create_select2([
                    "attr" => ["name" => "unit_asal=Kelas Asal", "id" => "unit_asal", "class" => "form-control"],
                    "model" => ["m_ms_unit" => "get_ms_unit", "column" => ["unit_id", "unit_name"]]
                ]) ?>
                <?= create_select([
                    "attr" => ["name" => "semester_asal", "id" => "semester_asal", "class" => "form-control"],
                    "option" => get_semester()
                ])
                ?>
                <?= create_input("tahun_pelajaran_asal") ?>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="text-align: center; min-height:10em;">
    <i style="font-size:8em" class="fa fa-fw fa-arrow-circle-right"></i>
    </div>
    <div class="col-md-5">
        <div class="panel panel-success panel-solid">
            <div class="panel-heading">
            <h3 class="panel-title">Tujuan Penjadwalan</h3>
            </div>
            <div class="panel-body">
                <?= create_select2([
                    "attr" => ["name" => "unit_tujuan=Kelas Tujuan ", "id" => "unit_tujuan", "class" => "form-control"],
                    "model" => ["m_ms_unit" => "get_ms_unit", "column" => ["unit_id", "unit_name"]]
                ]) ?>
                <?= create_select([
                    "attr" => ["name" => "semester_tujuan", "id" => "semester_tujuan", "class" => "form-control"],
                    "option" => get_semester()
                ])
                ?>
                <?= create_input("tahun_pelajaran_tujuan") ?>
            </div>
        </div>
    </div>
    <div class="col-md-12" align="center">
        <div class="panel-footer">
            <button class="btn btn-primary" type="button" onclick="$('#fm_copy_mp').submit()">Save</button>
            <button class="btn btn-warning" type="button" id="btn-close-mp">Cancel</button>
        </div>
    </div>
</div>
<?= form_close() ?>

<script>
    $("#fm_copy_mp").on("submit", function() {
        $.ajax({
            type: 'POST',
            url: 'schedule_mp/copy_schedule',
            dataType: 'json',
            data: $('#fm_copy_mp').serialize(),
            success: function(resp) {
                if (resp.code == '200') {
                    toastr.success(resp.message, "Message : ");
                    $("#modal_content").modal("hide");
                    toastr.options.onHidden=setTimeout(() => {
                        location.reload()
                    }, 2000);
                } else {
                    toastr.error(resp.message, "Message : ");
                }
            }
        });
        return false;
    });
</script>