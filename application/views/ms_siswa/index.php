<!-- Default panel -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Form Ms Siswa</h3>
    <div class="panel-options">
      <button type="button" id="btn-import" class="btn btn-success">
        <i class="entypo-plus"></i> Import</button>
      </button>
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>
  </div>
  <div class="panel-body" id="form_ms_siswa" style="display: none;">
  </div>
  <div class="panel-body" id="data_ms_siswa">
      <div class="row">
          <div class="col-md-2">
            <?= create_input("filter_tahun=Tahun Masuk") ?>
          </div>
          <div class="col-md-2">
            <?= create_select([
              "attr" => ["name" => "filter_jk=Jenis Kelamin", "id" => "filter_jk", "class" => "form-control"],
              "option" => [["id" => ' ', "text" => 'Pilih'], ["id" => 'L', "text" => "Laki-Laki"], ["id" => 'P', "text" => "Perempuan"]],
            ]) ?>
          </div>
          <div class="col-md-2">
          <?= create_select2([
                  "attr" => ["name" => "filter_kelas=Kelas", "id" => "filter_kelas", "class" => "form-control", 'required' => true],
                  "model" => [
                          "m_ms_unit" => "get_unit_kelas",
                          "column" => ["unit_id", "unit_name"]
                  ],
          ]) ?>
          </div>
          <div class="col-md-12">
          <?= create_table("tb_ms_siswa", "M_ms_siswa", ["class" => "table table-bordered datatable", "style" => "width:100% !important;"]) ?>
          </div>
      </div>
  </div>
</div>
<div class="panel-footer">
  <button class="btn btn-danger" id="btn-deleteChecked"><i class="fa fa-trash"></i> Delete</button>
</div>
<!-- /.panel-footer-->
</div>
<?= modal_open("modal_content", "Import Data Siswa")?>
<form action="http://localhost/smadu/ms_siswa/import_excel" method="post" id="fm_ms_siswa" enctype="multipart/form-data" accept-charset="utf-8">
  <div class="row">
    <div class="col-md-3">
<div class="form-group">
					<label>File Siswa</label>
					<input type="file" name="siswa_import" id="siswa_import">
				</div>       
</div>
</div>	

</form>
<div class="panel-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_ms_siswa').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div> 
<?= modal_close() ?>
<!-- /.panel -->
<script type="text/javascript">
  var table;
  var notifikasi = '<?= $this->session->flashdata("message") ?>';
  $(document).ready(function() {
    if (notifikasi) {
      notifikasi = JSON.parse(notifikasi)
      if (notifikasi.code == '200') {
        toastr.success(notifikasi.message, "Message : ");
      } else {
        toastr.error(notifikasi.message, "Message : ");
      }
    }
    table = $('#tb_ms_siswa').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('ms_siswa/get_data') ?>",
        "type": "POST",
        "data": function(f) {
          f.tahun = $("#filter_tahun").val();
          f.jk = $("#filter_jk").val();
          f.kelas = $("#filter_kelas").val();
        }
      },
      'columnDefs': [{
          'targets': [0, 1, -1],
          'searchable': false,
          'orderable': false,
        },
        {
          'targets': 0,
          'className': 'dt-body-center',
          'render': function(data, type, full, meta) {
            return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
          }
        }
      ],
    });
    // Initalize Select Dropdown after DataTables is created
    $('#tb_ms_siswa').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
    $("#filter_tahun,#filter_jk,#filter_kelas").change(() => {
      table.draw();
    });
  });
  $("#btn-add").click(function() {
    $("#form_ms_siswa").show();
    $("#form_ms_siswa").load("ms_siswa/show_form");
  });

  function set_val(id) {
    $("#form_ms_siswa").show();
    $.get('ms_siswa/find_one/' + id, (data) => {
      $("#form_ms_siswa").load("ms_siswa/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('ms_siswa/delete_row/' + id, (data) => {
        if (data.code == '200') {
          toastr.success(data.message, "Message : ");
        } else {
          toastr.error(data.message, "Message : ");
        }
        toastr.options.onHidden = setTimeout(() => {
          location.reload()
        }, 2000);
      }, 'json');
    }
  }

  $("#checkAll").click(() => {
    if ($("#checkAll").is(':checked')) {
      $("#tb_ms_siswa input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_ms_siswa input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function(event) {
    event.preventDefault();
    var searchIDs = $("#tb_ms_siswa input:checkbox:checked").map(function() {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('ms_siswa/delete_multi', {
        data: searchIDs
      }, (resp) => {
        if (resp.code == '200') {
          toastr.success(resp.message, "Message : ");
        } else {
          toastr.error(resp.message, "Message : ");
        }
        toastr.options.onHidden = setTimeout(() => {
          location.reload()
        }, 2000);
      }, 'json');
    }
  });

  $("#btn-import").click(()=>{
    $("#modal_content").modal('show');
    // $("#modal_content").find(".modal-body").load("ms_siswa/import_excel");
    
  })
  <?= $this->config->item('footerJS') ?>
</script>