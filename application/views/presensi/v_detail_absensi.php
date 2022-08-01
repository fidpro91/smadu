<style>
    .gambar {
        width: 50%;
        height: auto;
    }
    .datepicker{z-index:9999 !important}
</style>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-options">
                <?= create_inputDate("filter_tanggal=Tanggal", ["format" => "yyyy-mm-dd", "autoclose" => true]) ?>
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td style="text-align: center !important;" colspan="2">
                            <img src="<?= site_url($siswa->photo??"assets/images/icon/siswa.png") ?>" class="gambar" alt="<?= $siswa->st_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td style="text-align: right;"><?= $siswa->st_nis ?></td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td style="text-align: right;"><?= $siswa->st_name ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td style="text-align: right;"><?= $siswa->st_sex ?></td>
                    </tr>
                    <tr>
                        <td>Tempat/Tanggal Lahir</td>
                        <td style="text-align: right;"><?= $siswa->st_born."/".$siswa->st_birthdate ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Terdaftar</td>
                        <td style="text-align: right;"><?= $siswa->st_th_masuk ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td style="text-align: right;"><?= $siswa->unit_name ?></td>
                    </tr>
                    <tr>
                        <td>Wali Siswa (Bapak/Ibu)</td>
                        <td style="text-align: right;">
                            <?= $siswa->st_father."/".$siswa->st_mother ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td style="text-align: right;"><?= $siswa->st_phone ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="text-align: right;"><?= $siswa->st_email ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td style="text-align: right;"><?= $siswa->st_address ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <?php
                $tile=['tile-green','tile-aqua','tile-red'];
                foreach(get_absen() as $x=>$rs):
                    $jumlah_absen=0;
                if($rs['id']!='0' && $rs['id'] != 4):
                    $key_abs = array_search($rs['id'], array_column($header, 'absen_type'));
                    if ($key_abs !== false) {
                        $jumlah_absen = $header[$key_abs]['jml'];
                    }
            ?>
            <div class="col-sm-4 col-xs-6">
                <div class="tile-stats <?=$tile[$x-1]?>">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="100" data-postfix="" data-duration="1500" data-delay="0"><?=$jumlah_absen?></div>
                    <h3><?=$rs['text']?></h3>
                </div>
            </div>
            <?php
                endif;
                endforeach;
            ?>
        </div>
       
        <div class="col-sm-12">
   
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Data Absen</div>               
        </div> 
       
  
      
<table class="table table-bordered" id="tabel_absen" >
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Absen</th>
            <th>Hari</th>
            <th>Tgl & Jam</th>
            <th>Jenis Absen</th>
            <th>Keterangan</th>           
        </tr>
    </thead>
   <tbody>
        <?php
       
            foreach ($dta as $key => $value) {
                
                if(date('N', strtotime($value->absen_date))=="7"){
                    $day =0;
                }else{
                    $day = date('N', strtotime($value->absen_date));
                }
                $day = show_hari($day);

                if ($value->late_duration_in>0) {
                    $txt = "Lebih awal $a Menit";
                }elseif($value->late_duration_in==0){
                    $txt = "";
                }else{
                    $txt = "Lebih lambat ".abs($value->late_duration_in)." Menit";
                }
             
              echo " 
                    <tr>
                        <td>".($key+1)."</td>
                        <td>$value->absen_date</td>
                        <td>$day</td>
                        <td>$value->check_in</td>
                        <td>".get_absen($value->absen_type)."</td>  
                        <td>$txt</td>                     
                    </tr>
                ";
            }
            
        ?>
        
    </tbody>
</table>
        </div>

    </div>

</div>
    </div>
</div>
<script type="text/javascript">
 $("#tabel_absen").DataTable();
 <?= $this->config->item('footerJS') ?>
</script>