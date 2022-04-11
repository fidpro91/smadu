<!-- Default panel -->
<div class="panel panel-gradient">
  <div class="panel-heading">
    <h3 class="panel-title">Form Schedule Mp</h3>
    <div class="panel-options">
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>
  </div>
  <div class="panel-body" id="form_schedule_mp" style="display: none;">
  </div>
  <div class="panel-body" id="data_schedule_mp">
    <div class="row">
      <div class="col-md-3">
          <?= create_select2([
                "attr" => ["name" => "filter_kelas=Kelas", "id" => "filter_kelas", "class" => "form-control", 'required' => true],
                "model" => [
                        "m_ms_unit" => ["get_ms_unit", ["unit_type" => $this->setting->kategori_kelas]],
                        "column" => ["unit_id", "unit_name"]
                ],
        ]) ?>
      </div>
      <div class="col-md-3">
          <?= create_select([
              "attr" => ["name" => "filter_semester=semester", "id" => "filter_semester", "class" => "form-control"],
              "option" => get_semester()
            ])
          ?>
      </div>
      <div class="col-md-3">
          <?= create_input("filter_tahun=tahun pelajaran") ?>
      </div>
      <div class="col-md-12">
        <?=create_table("tb_schedule_mp","M_schedule_mp",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <button class="btn btn-danger" id="btn-deleteChecked"><i class="fa fa-trash"></i> Delete</button>
    <button class="btn btn-success" id="btn-copy"><i class="fa fa-copy"></i> Copy Jadwal</button>
  </div>
  <!-- /.panel-footer-->
</div>
<!-- /.panel -->
<?= modal_open("modal_content", "Jadwal Mata Pelajaran","modal-lg") ?>
    <?= form_open("absensi_siswa/save", ["method" => "post", "class" => "form-horizontal", "id" => "fm_absensi_siswa","enctype"=>"multipart/form-data"]) ?>
<?= modal_close() ?>
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
    table = $('#tb_schedule_mp').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('schedule_mp/get_data')?>",
        "type": "POST",
        "data":function(f){
            f.kelas=$("#filter_kelas").val();
            f.semester=$("#filter_semester").val();
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
    $('#tb_schedule_mp').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });

    $("#filter_kelas, #filter_semester, #filter_tahun").change(()=>{
      table.draw();
    });
  });
  $("#btn-add").click(function () {
    $("#form_schedule_mp").show();
    $("#data_schedule_mp").hide();
    $("#form_schedule_mp").load("schedule_mp/show_form");
  });

  function set_val(id) {
    $("#modal_content").modal('show');
    $("#modal_content").find(".modal-body").load("schedule_mp/show_form_update", () => {
        $.get('schedule_mp/find_one/' + id, (data) => {
          $.each(data, (ind, obj) => {
            if (ind == 'guru_id' || ind == 'class_id') {
              $("#" + ind).val(obj).trigger('change');
            }else{
              $("#" + ind).val(obj);
            }

          });
        }, 'json');
      });
  }

  $("#btn-copy").click(()=>{
    $("#modal_content").modal('show');
    $("#modal_content").find(".modal-body").load("schedule_mp/form_copy");
  })

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('schedule_mp/delete_row/' + id, (data) => {
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
      $("#tb_schedule_mp input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_schedule_mp input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_schedule_mp input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('schedule_mp/delete_multi', { data: searchIDs }, (resp) => {
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