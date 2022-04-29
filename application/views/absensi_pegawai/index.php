<!-- Default panel -->
<div class="panel panel-gradient">
  <div class="panel-heading">
    <h3 class="panel-title">Form Absensi Pegawai</h3>
    <div class="panel-options">
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>
  </div>
  <div class="panel-body" id="form_absensi_pegawai" style="display: none;">
  </div>
  <div class="panel-body" id="data_absensi_pegawai">
    <div class="row">
        <div class="col-md-3">
          <?= create_inputDate("filter_tanggal=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
        </div>
        <div class="col-md-3">
            <?= create_select2(["attr" => ["name" => "filter_unit=Tempat Ruangan", "id" => "filter_unit", "class" => "form-control"],
            "model" => ["m_ms_unit" => "get_ms_unit", "column" => ["unit_id", "unit_name"]]
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= create_select([
              "attr" => ["name" => "filter_verifikasi=Verifikasi", "id" => "filter_verifikasi", "class" => "form-control"],
                "option" => [["id" => 't', "text" => "Sudah"], ["id" => 'f', "text" => "Belum"]],
            ]) ?>
        </div>
        <script>
          <?=$this->config->item('footerJS')?>
        </script>
        <div class="col-md-12">
            <?=create_table("tb_absensi_pegawai","M_absensi_pegawai",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
        </div>
    </div>
  </div>
  <div class="panel-footer">
    <!-- <button class="btn btn-success" id="btn-deleteChecked"><i class="fa fa-check"></i> Verifikasi</button> -->
    <button class="btn btn-success" id="btn-verif"><i class="fa fa-check"></i> Verifikasi</button>
  </div>
  <!-- /.panel-footer-->
</div>
<!-- /.panel -->
<script type="text/javascript">
  var table;
  var notifikasi = '<?=$this->session->flashdata("message")?>';
  $(document).ready(function () {
    if (notifikasi) {
      notifikasi = JSON.parse(notifikasi)
      if (notifikasi.code == '200') {
        toastr.success(notifikasi.message, "Message : ");
      } else {
        toastr.error(notifikasi.message, "Message : ");
      }
    }
    table = $('#tb_absensi_pegawai').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('absensi_pegawai/get_data')?>",
        "type": "POST",
        "data":function(f){
            f.unit=$("#filter_unit").val();
            f.tanggal=$("#filter_tanggal").val();
            f.verifikasi=$("#filter_verifikasi").val();
          }
      },
      'columnDefs': [
        {
          'targets': [0, 1, -1],
          'searchable': false,
          'orderable': false,
        },
        {
          'targets': 0,
          'className': 'dt-body-center',
          'render': function (data, type, full, meta) {
            return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
          }
        }],
    });
    // Initalize Select Dropdown after DataTables is created
    $('#tb_absensi_pegawai').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
    $("#filter_unit, #filter_tanggal, #filter_verifikasi").change(()=>{
      table.draw();
    });
  });
  $("#btn-add").click(function () {
    $("#form_absensi_pegawai").show();
    $("#form_absensi_pegawai").load("absensi_pegawai/show_form");
  });
  function set_val(id) {
    $("#form_absensi_pegawai").show();
    $.get('absensi_pegawai/find_one/' + id, (data) => {
      $("#form_absensi_pegawai").load("absensi_pegawai/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('absensi_pegawai/delete_row/' + id, (data) => {
        if (data.code == '200') {
          toastr.success(data.message, "Message : ");
        } else {
          toastr.error(data.message, "Message : ");
        }
        toastr.options.onHidden=setTimeout(() => {
          location.reload()
        }, 2000);
      }, 'json');
    }
  }

  $("#checkAll").click(() => {
    if ($("#checkAll").is(':checked')) {
      $("#tb_absensi_pegawai input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_absensi_pegawai input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_absensi_pegawai input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('absensi_pegawai/delete_multi', { data: searchIDs }, (resp) => {
        if (resp.code == '200') {
          toastr.success(resp.message, "Message : ");
        } else {
          toastr.error(resp.message, "Message : ");
        }
        toastr.options.onHidden=setTimeout(() => {
          location.reload()
        }, 2000);
      }, 'json');
    }
  });
  $("#btn-verif").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_absensi_pegawai input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan diverifikasi");
      return false;
    }
    if (confirm("Anda yakin akan menverifikasi data ini?")) {
      $.post('absensi_pegawai/verifikasi_multi', { data: searchIDs }, (resp) => {
        if (resp.code == '200') {
          toastr.success(resp.message, "Message : ");
        } else {
          toastr.error(resp.message, "Message : ");
        }
        toastr.options.onHidden=setTimeout(() => {
          location.reload()
        }, 2000);
      }, 'json');
    }
  });
</script>