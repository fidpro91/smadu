<div class="row">
    <?php
    foreach($data as $x=>$row):
    ?>
    <div class="col-md-4" onclick="info_absen(<?=$row['st_id']?>,'<?=$row['st_name']?>')">
        <div class="member-entry">
            <a href="extra-timeline.html" class="member-img">
                <img src="<?=base_url()?>assets/images/icon/siswa.png" class="img-rounded" style="width: 2000px !important;"/>
                <i class="entypo-forward"></i>
            </a>
            <div class="member-details">
                <h4>
                    <a href="extra-timeline.html" class="nama_siswa"><?=$row['st_name']?></a>
                </h4>
                <!-- Details with Icons -->
                <div class="row info-list">
                    <div class="col-sm-12">
                        <i class="entypo-vcard"></i>
                        Kelas <a href="#"><?=$row["unit_name"]?></a>
                    </div>
                    <div class="col-sm-12">
                        <i class="entypo-calendar"></i>
                        Absensi <a href="#"><?=get_absen($row["absen_type"])?></a>
                    </div>
                    <div class="col-sm-12">
                        <i class="entypo-info"></i>
                        Keterangan <a href="#">
                        <?php
                            if ($row["late_duration_in"]>0) {
                                $txt = "Lebih awal ".$row["late_duration_in"]." Menit";
                            }elseif($row["late_duration_in"]==0){
                                $txt = "";
                            }else{
                                $txt = "Lebih lambat ".abs($row["late_duration_in"])." Menit";
                            }
                            echo $txt;
                        ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endforeach;
    ?>
</div>
<?=modal_open("modal_detail_absen","Informasi Absensi","",[
    "style" => "width:80%"
])?>
<?=modal_close()?>
<script>
    function info_absen(id,nama="") {
        $("#modal_detail_absen").modal("show");
        $("#modal_detail_absen").find(".modal-body").load("<?=base_url("absensi_siswa/show_detail_presensi/")?>/"+id);
        $("#modal_detail_absen").find(".modal-header > .modal-content > .modal-title").text("Informasi Absensi#"+nama);
    }
</script>