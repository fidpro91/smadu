<!-- Default panel -->
<div class="panel panel-gradient">
  <div class="panel-heading">
    <h3 class="panel-title">Form User Activity</h3>
    <div class="panel-options">
    </div>
  </div>
  <div class="panel-body" id="form_user_activity" style="display: none;">
  </div>
  <div class="panel-body" id="data_user_activity">
    <?=create_table("tb_user_activity","M_user_activity",["class"=>"table table-bordered datatable" ,"style" => "width:100% !important;"])?>
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
    table = $('#tb_user_activity').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "scrollX": true,
      "ajax": {
        "url": "<?php echo site_url('user_activity/get_data')?>",
        "type": "POST"
      },
      'columnDefs': [
        {
          'targets': [0, 1, -1],
          'searchable': false,
          'orderable': false,
        },
        {
          'targets': [0, -1],
          'visible': false,
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
    $('#tb_user_activity').closest('.dataTables_wrapper').find('select').select2({
      minimumResultsForSearch: -1
    });
  });
  $("#btn-add").click(function () {
    $("#form_user_activity").show();
    $("#form_user_activity").load("user_activity/show_form");
  });
  function set_val(id) {
    $("#form_user_activity").show();
    $.get('user_activity/find_one/' + id, (data) => {
      $("#form_user_activity").load("user_activity/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
        });
      });
    }, 'json');
  }

  function deleteRow(id) {
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.get('user_activity/delete_row/' + id, (data) => {
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
      $("#tb_user_activity input[type='checkbox']").attr("checked", true);
    } else {
      $("#tb_user_activity input[type='checkbox']").attr("checked", false);
    }
  });

  $("#btn-deleteChecked").click(function (event) {
    event.preventDefault();
    var searchIDs = $("#tb_user_activity input:checkbox:checked").map(function () {
      return $(this).val();
    }).toArray();
    if (searchIDs.length == 0) {
      alert("Mohon cek list data yang akan dihapus");
      return false;
    }
    if (confirm("Anda yakin akan menghapus data ini?")) {
      $.post('user_activity/delete_multi', { data: searchIDs }, (resp) => {
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