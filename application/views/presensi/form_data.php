<div class="row">
    <?php
    foreach($data as $x=>$row):
    ?>
    <div class="col-md-3">
        <div class="member-entry">
            <a href="extra-timeline.html" class="member-img">
                <img src="<?=base_url()?>assets/images/icon/siswa.png" class="img-rounded" style="width: 2000px !important;"/>
                <i class="entypo-forward"></i>
            </a>
            <div class="member-details">
                <h4>
                    <a href="extra-timeline.html"><?=$row['st_name']?></a>
                </h4>
                <!-- Details with Icons -->
                <div class="row info-list">
                    <div class="col-sm-6">
                        <i class="entypo-briefcase"></i>
                        Kelas <a href="#"><?=$row["unit_name"]?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endforeach;
    ?>
</div>