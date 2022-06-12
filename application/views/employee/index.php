<!-- Default panel -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Form Employee</h3>
    <div class="panel-options">
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>   
  </div>
  
  <div class="panel-body" id="form_employee" style="display: none;">
  </div> 
  <div class="panel-body" id="data_employee">
  <div class="col-md-4">         
            <?= create_select2(["attr" => ["name" => "filter_class=Kategori", "id" => "filter_class", "class" => "form-control"],
                "model" => ["m_employee_categories" => ["get_employee_categories", ["0" => '0']], "column" => ["empcat_id", "empcat_name"]]
            ]) ?>
  </div>
  <div class="col-md-4">
            <?= create_select2(["attr" => ["name" => "filter_jabatan=jabatan", "id" => "filter_jabatan", "class" => "form-control"],
                "model" => ["m_ms_reff" => ["get_ms_reff", ["refcat_id" => '5']], "column" => ["reff_id", "reff_name"]]
            ]) ?>
          </div>
    <?=create_table("tb_employee","M_employee",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
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
    table = $('#tb_employee').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('employee/get_data')?>",
        "type": "POST",
        "data":function(f){
                  f.empcat_id=$("#filter_class").val();
                  f.jb=$("#filter_jabatan").val();
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
    $('#tb_employee').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
    $("#filter_class,#filter_jabatan").change(()=>{
            table.draw();
            });
  });
  $("#btn-add").click(function () {
    $("#form_employee").show();
    $("#form_employee").load("employee/show_form");
  });
  function set_val(id) {
    $("#form_employee").show();    
    $.get('employee/find_one/' + id, (data) => {
      $("#form_employee").load("employee/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);         
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('employee/delete_row/' + id, (data) => {
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
      $("#tb_employee input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_employee input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_employee input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('employee/delete_multi', { data: searchIDs }, (resp) => {
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