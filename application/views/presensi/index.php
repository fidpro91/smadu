<div class="row">
    <div class="col-md-3">
        <!-- Default panel -->
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <h3 class="panel-title">Presensi Harian</h3>
                <div class="panel-options">
                </div>
            </div>
            <div class="panel-body">
                <?=form_open("ms_user/save",["method"=>"post","class"=>"form-horizontal","id"=>"fm_filter"])?>
                    <div class="col-md-12">
                        <?= create_inputDate("filter_tanggal=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
                        <?= create_select2(["attr" => ["name" => "filter_unit=kelas", "id" => "filter_unit", "class" => "form-control"],
                        "model" => ["m_ms_unit" => "get_unit_kelas", "column" => ["unit_id", "unit_name"]]
                        ]) ?>
                    </div>
                    <div class="col-md-12">
                        <button style="width: 100% !important;" class="btn btn-primary">Tampilkan</button>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <!-- Default panel -->
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <h3 class="panel-title">Form Absensi Mata Pelajaran</h3>
                <div class="panel-options">
                    <div class="input-group">
                        <input type="text" class="form-control" id="filter_name">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="loadPagination(0)">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="list_data">
            </div>
            <!-- /.panel-footer-->
            <div style='margin-top: 10px;' id='pagination'></div>
        </div>
        <!-- /.panel -->
    </div>
</div>
<script>
    $(document).ready(() => {
        loadPagination(0);
        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno);
        });
    });

    function loadPagination(pagno) {
        $.ajax({
            url: '<?= base_url() ?>absensi_siswa/load_record/' + pagno,
            type: 'post',
            data: $("#fm_filter").serialize()+"&filter_name="+$("#filter_name").val(),
            dataType: 'json',
            success: function(response) {
                $('#pagination').html(response.pagination);
                $("#list_data").html(response.result);
            }
        });
    }
    
    $("#fm_filter").on("submit",function(){
        loadPagination(0);
        return false;
    })
    <?= $this->config->item('footerJS') ?>
</script>