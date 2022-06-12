<!-- Default panel -->
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Form Employee Categories</h3>
    <div class="panel-options">
      <button type="button" id="btn-add" class="btn btn-black">
        <i class="entypo-plus"></i> Add</button>
    </div>
  </div>
  <div class="panel-body" id="form_employee_categories" style="display: none;">
  </div>
  <div class="panel-body" id="data_employee_categories">
    <?=create_table("tb_employee_categories","M_employee_categories",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
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
    table = $('#tb_employee_categories').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('employee_categories/get_data')?>",
        "type": "POST"
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
    $('#tb_employee_categories').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
  });
  $("#btn-add").click(function () {
    $("#form_employee_categories").show();
    $("#form_employee_categories").load("employee_categories/show_form");
  });
  function set_val(id) {
    $("#form_employee_categories").show();
    $.get('employee_categories/find_one/' + id, (data) => {
      $("#form_employee_categories").load("employee_categories/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('employee_categories/delete_row/' + id, (data) => {
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
      $("#tb_employee_categories input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_employee_categories input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_employee_categories input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('employee_categories/delete_multi', { data: searchIDs }, (resp) => {
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