   <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <?=$this->session->flashdata('message')?>
        <div class="box-header with-border">
          <h3 class="box-title">FORM LAPORAN REKAPITULASI ABSENSI SISWA</h3>
          <div class="box-tools pull-right">
          </div>
<br>
 </div> 
<?=form_open("rekap_absensi/show_laporan",["method"=>"post","id"=>"formlaporan","target"=>"blank"])?>      
        <div class="box-body" id="rekap">        
          <div class="col-md-6" >
         <?=create_inputDate("tanggal=BULAN",[
						"format"		=>"mm-yyyy",
						"viewMode"		=> "year",
						"minViewMode"	=> "year",
						"autoclose"		=>true])
				?>         
          <?= create_select([
            "attr" => ["name" => "filter_absen=JENIS ABSEN", "id" => "filter_absen", "class" => "form-control"],
            "option" => get_absen()
          ])
        ?>  
		<?= create_select([
              "attr" => ["name" => "filter_verifikasi=VERIFIKASI", "id" => "filter_verifikasi", "class" => "form-control"],
                "option" => [["id" => 't', "text" => "Sudah"], ["id" => 'f', "text" => "Belum"]],
            ]) ?> 
				<?= create_select2(["attr" => ["name" => "filter_unit=KELAS", "id" => "filter_unit", "class" => "form-control",
        "required"=>true],
			"model" =>[
				"m_ms_unit" => ["get_ms_unit", ["unit_type" => $this->setting->kategori_kelas]],
				"column"  => ["unit_id", "unit_name"]
			],
			]) ?>          
        <br><br>
       <button class="btn btn-primary" type="button" onclick="$('#formlaporan').submit()">Tampilkan</button>
       <input class="btn btn-success" type="submit" value="Excel" name="dtlPas">      
       </div>
     </div>

<?=form_close()?>

      
</div>
    </section>
    <!-- /.content -->
  </div>  

<script type="text/javascript">
      $(document).ready(function() {
     // $('.select2').select2();     
    });   
    $("#formlaporan").on("submit",()=>{
      if ($("#tanggal").val() === '' ) {
        alert("Mohon di isi Bulan");
        return false;       
      }else if($("#filter_unit").val() === ''){
        alert("Mohon di isi kelas");
        return false;
      }
    }); 
    <?=$this->config->item('footerJS')?>
</script>