<!-- Default panel -->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <h3 class="panel-title">Form Absensi Mata Pelajaran</h3>
        <div class="panel-options">
        </div>
    </div>
    <div class="panel-body" id="list_data">
    </div>
    <!-- /.panel-footer-->
    <div style='margin-top: 10px;' id='pagination'></div>
</div>
<!-- /.panel -->
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
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#pagination').html(response.pagination);
                $("#list_data").html(response.result);
            }
        });
    }
</script>