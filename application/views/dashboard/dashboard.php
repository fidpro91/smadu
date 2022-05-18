<script src="<?= base_url() ?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?= base_url() ?>assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="<?= base_url() ?>assets/js/rickshaw/rickshaw.min.js"></script>
<script src="<?= base_url() ?>assets/js/raphael-min.js"></script>
<script src="<?= base_url() ?>assets/js/morris.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Sample Toastr Notification
        setTimeout(function() {
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
                "toastClass": "blue",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("You have been awarded with 1 year free subscription. Enjoy it!", "Account Subcription Updated", opts);
        }, 3000);


        // Sparkline Charts
        $('.inlinebar').sparkline('html', {
            type: 'bar',
            barColor: '#ff6264'
        });
        $('.inlinebar-2').sparkline('html', {
            type: 'bar',
            barColor: '#445982'
        });
        $('.inlinebar-3').sparkline('html', {
            type: 'bar',
            barColor: '#00b19d'
        });
        $('.bar').sparkline([
            [1, 4],
            [2, 3],
            [3, 2],
            [4, 1]
        ], {
            type: 'bar'
        });
        $('.pie').sparkline('html', {
            type: 'pie',
            borderWidth: 0,
            sliceColors: ['#3d4554', '#ee4749', '#00b19d']
        });
        $('.linechart').sparkline();
        $('.pageviews').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#ff6264'
        });
        $('.uniquevisitors').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#00b19d'
        });


        $(".monthly-sales").sparkline([1, 2, 3, 5, 6, 7, 2, 3, 3, 4, 3, 5, 7, 2, 4, 3, 5, 4, 5, 6, 3, 2], {
            type: 'bar',
            barColor: '#485671',
            height: '80px',
            barWidth: 10,
            barSpacing: 2
        });
    });

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>
<div class="row">
    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-users"></i></div>
            <div class="num" data-start="0" data-end="<?= $siswa ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>

            <h3>Siswa Aktif</h3>
        </div>

    </div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div class="num" data-start="0" data-end="<?=$unit_count?>" data-postfix="" data-duration="1500" data-delay="600">0</div>
            <h3>Unit Aktif</h3>
        </div>

    </div>

    <div class="clear visible-xs"></div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-aqua">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div class="num" data-start="0" data-end="<?= $pegawai ?>" data-postfix="" data-duration="1500" data-delay="1200">0</div>
            <h3>Karyawan Aktif</h3>
        </div>

    </div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-rss"></i></div>
            <div class="num" data-start="0" data-end="<?=$mataPelajaran?>" data-postfix="" data-duration="1500" data-delay="1800">0</div>
            <h3>Mata Pelajaran</h3>
        </div>

    </div>
</div>

<br />
<style>
    .gambar {
        width: 50%;
        height: auto;
    }
</style>
<div class="row">
    
<div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td style="text-align: center !important;" colspan="2">
                            <img src="<?= site_url($instansi->logo1) ?>" class="gambar" alt="<?= $instansi->nama_instansi ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Kode Instansi</td>
                        <td style="text-align: right;"><?= $instansi->kode_instansi ?></td>
                    </tr>
                    <tr>
                        <td>Nama Instansi</td>
                        <td style="text-align: right;"><?= $instansi->nama_instansi ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Berdiri</td>
                        <td style="text-align: right;"><?= $instansi->tanggal_berdiri ?></td>
                    </tr>
                    <tr>
                        <td>Status Akreditasi</td>
                        <td style="text-align: right;"><?= $instansi->status_akreditasi ?></td>
                    </tr>
                    <tr>
                        <td>Kepala Instansi</td>
                        <td style="text-align: right;"><?= $instansi->kepala_instansi ?></td>
                    </tr>
                    <tr>
                        <td>Website</td>
                        <td style="text-align: right;">
                            <a href="<?= $instansi->website ?>" target="blank"><?= $instansi->website ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td style="text-align: right;"><?= $instansi->no_telp ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="text-align: right;"><?= $instansi->email ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td style="text-align: right;"><?= $instansi->alamat_instansi ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Grafik Jumlah Siswa</div>
            </div>
            <div class="panel-body">
                <div id="chart5" style="height: 250px"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Grafik Jumlah Pegawai</div>
            </div>
            <div class="panel-body">
                <div id="chart6" style="height: 250px"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-heading">
                <div class="panel-title">Grafik Absensi Siswa</div>
                <div class="panel-options" style="width: 30% !important;">
                <?=form_dropdown("filter_class",$unit,'','class="form-control select2" id="filter_class"')?>
                </div>
            </div>
            <div class="panel-body">
                <div id="chart3" class="morrischart" style="height: 300px;"></div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Grafik Absensi Pegawai</div>
                <div class="panel-options"  style="width: 30% !important;">
                <?=form_dropdown("filter_unit",$unitKerja,'','class="form-control select2" id="filter_unit"')?>
                </div>
            </div>
            <div class="panel-body">
                <div id="chart4" class="morrischart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">

    <div class="col-sm-4">

        <div class="panel panel-primary">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="padding-bottom-none text-center">
                            <br />
                            <br />
                            <span class="monthly-sales"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="panel-heading">
                            <h4>Monthly Sales</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="col-sm-8">

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Aktifitas User</div>

                <div class="panel-options">
                    <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                    <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                </div>
            </div>
            <?=create_report_custom([ 
                    "ext" 		=> ['class'=>'table table-bordered table-responsive','border'=>'1','width'=>'100%'],
                    "name" 		=> "tabel_actifity",
                    "column" 	=> [
                                    "act_date",
                                    "person_name",
                                    "keterangan"
                                    ],
                    "data" 		=> $user_activity, 
            ])?>
        </div>

    </div>

</div>

<br />


<script type="text/javascript">
    // Code used to add Todo Tasks
    jQuery(document).ready(function($) {
        var $todo_tasks = $("#todo_tasks");
        $("#tabel_actifity").DataTable();
        $todo_tasks.find('input[type="text"]').on('keydown', function(ev) {
            if (ev.keyCode == 13) {
                ev.preventDefault();

                if ($.trim($(this).val()).length) {
                    var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>' + $(this).val() + '</label></div></li>');
                    $(this).val('');

                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                    $todo_entry.hide().slideDown('fast');
                    replaceCheckboxes();
                }
            }
        });

        $.ajax({
            url: '<?= base_url() ?>dashboard/get_data_chart/',
            type: 'post',
            data: $("#fm_filter").serialize()+"&filter_name="+$("#filter_name").val(),
            dataType: 'json',
            success: function(response) {
                // Bar Charts
                Morris.Bar({
                    element: 'chart3',
                    axes: true,
                    data: response.data,
                    xkey: response.xkey,
                    ykeys: response.ykeys,
                    labels: response.labels,
                    barColors: ['#707f9b', '#455064', '#242d3c']
                });
            }
        });

        $.ajax({
            url: '<?= base_url() ?>dashboard/get_data_chart_absen_pegawai/',
            type: 'post',
            data: $("#fm_filter").serialize()+"&filter_name="+$("#filter_name").val(),
            dataType: 'json',
            success: function(response) {
                // Bar Charts
                Morris.Bar({
                    element: 'chart4',
                    axes: true,
                    data: response.data,
                    xkey: response.xkey,
                    ykeys: response.ykeys,
                    labels: response.labels,
                    barColors: ['#707f9b', '#455064', '#242d3c']
                });
            }
        });

        $.ajax({
            url: '<?= base_url() ?>dashboard/get_data_chart_siswa/',
            type: 'post',
            data: $("#fm_filter").serialize()+"&filter_name="+$("#filter_name").val(),
            dataType: 'json',
            success: function(response) {
                Morris.Donut({
                    element: 'chart5',
                    data: response
                });
            }
        });

        $.ajax({
            url: '<?= base_url() ?>dashboard/get_data_chart_pegawai/',
            type: 'post',
            data: $("#fm_filter").serialize()+"&filter_name="+$("#filter_name").val(),
            dataType: 'json',
            success: function(response) {
                Morris.Donut({
                    element: 'chart6',
                    data: response
                });
            }
        });
    });
</script>