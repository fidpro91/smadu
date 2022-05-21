<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?= ucwords('Profil Instansi') ?>
    </h1>
   
  </section>
  <!-- Main content -->
  <section class="content">
<section class="content">
  <div class="box">
    <?= $this->session->flashdata('message') ?>
      <div class="box-header with-border">
        <h3 class="box-title">
        <div class="box-tools pull-right">
          <div class="btn-group">
            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-wrench" href="#" onclick="set_val()"></i></button>
            <!-- <ul class="dropdown-menu" role="menu"> -->
              <!-- <li><a href="#" onclick="set_val()">Edit</a></li> -->
            </ul>
          </div>
        </div>
      </div>
      <div class="box-body" id="form_company_profil" style="display: none;">
      </div>
      <div class="box-body" id="data_company_profil">
        <table class="table">
          <tr>
            <td rowspan="5" style="width: 20%; text-align:center;">
              <img src="<?= base_url($smadu->logo1??'assets/images/icon/logo_du.png') ?>"></img>
            </td>
          </tr>
          <tr>
            <td style="width: 15%;">Kode Instansi</td>
            <td style="width: 2%;">:</td>
            <td id="kodeuniv"><?= $smadu->kode_instansi ?></td>
          </tr>
          <tr>
            <td>Nama Instansi</td>
            <td>:</td>
            <td><?= $smadu->nama_instansi ?></td>
          </tr>
          <tr>
            <td>Tanggal Berdiri</td>
            <td>:</td>
            <td><?= $smadu->tanggal_berdiri ?></td>
          </tr>
          <tr>
            <td>Kepala Sekolah</td>
            <td>:</td>
            <td></td>
          </tr>
</table>
<table class="table">
          <tr>
            <td style="width: 15%;">Status Akreditasi</td>
            <td style="width: 2%;">:</td>
            <td><?= $smadu->status_akreditasi ?></td>
          </tr>
          <tr>
            <td>Tanggal Akreditasi</td>
            <td>:</td>
            <td><?= $smadu->tanggal_akreditasi ?></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?= $smadu->alamat_instansi ?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td><?= $smadu->email ?></td>
          </tr>
          <tr>
            <td>Website</td>
            <td>:</td>
            <td><?= $smadu->website ?></td>
          </tr>
        </table>
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.panel -->
<script type="text/javascript">

  $("#btn-add").click(function () {
    $("#form_company_profil").show();
    $("#form_company_profil").load("company_profil/show_form");
  });
  function set_val() {
    $("#form_company_profil").show();
    $("#data_company_profil").hide();
    $.get('company_profil/find_one/' + $("#kodeuniv").text(), (data) => {
      $("#form_company_profil").load("company_profil/show_form", () => {
        $.each(data, (ind, obj) => {
          $("#" + ind).val(obj);
        });
      });
    }, 'json');
  }


</script>