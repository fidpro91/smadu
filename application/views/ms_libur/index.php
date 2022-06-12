<!-- Default panel -->
<div class="panel panel-gradient">
  <div class="panel-heading">
    <h3 class="panel-title">Form Ms Libur</h3>
    <div class="panel-options">
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>
  </div>
  <div class="panel-body" id="form_ms_libur" style="display: none;">
  </div>
  <div class="panel-body" id="data_ms_libur">
    <div class="row">
        <div class="col-md-3">
        <?= create_select([
            "attr" => ["name" => "filter_libur_type=diperuntukkan", "id" => "filter_libur_type", "class" => "form-control", 'required' => true],
            "option" => [
                ["id" => '1', "text" => "Siswa"],
                ["id" => '2', "text" => "Pegawai"]
            ]
        ]) ?>
        </div>
        <div class="col-md-3">
          <?= create_input("filter_tahun=tahun") ?>
        </div>
        <div class="col-md-12">
            <?=create_table("tb_ms_libur","M_ms_libur",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
        </div>
    </div>
  </div>
  <div class="panel-footer">
    <button class="btn btn-danger" id="btn-deleteChecked"><i class="fa fa-trash"></i> Delete</button>
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
    table = $('#tb_ms_libur').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [[6, 'desc'],[5, 'asc']],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('ms_libur/get_data')?>",
        "type": "POST",
        "data":function(f){
            f.libur_type=$("#filter_libur_type").val();
            f.tahun=$("#filter_tahun").val();
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
    $('#tb_ms_libur').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
    $("#filter_libur_type, #filter_tahun").change(()=>{
      table.draw();
    });
  });
  $("#btn-add").click(function () {
    $("#form_ms_libur").show();
    $("#form_ms_libur").load("ms_libur/show_form");
  });
  function set_val(id) {
    $("#form_ms_libur").show();
    $.get('ms_libur/find_one/' + id, (data) => {
      $("#form_ms_libur").load("ms_libur/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
          if (ind == "perulangan_libur") {
            $("#" + ind).val(obj).trigger("change");
          }
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('ms_libur/delete_row/' + id, (data) => {
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
      $("#tb_ms_libur input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_ms_libur input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_ms_libur input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('ms_libur/delete_multi', { data: searchIDs }, (resp) => {
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