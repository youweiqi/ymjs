<div class="serial-view" style="padding:15px 15px;border:1px solid #D8DCE3">
    <div >
        <img style="width: 100%" src="<?php echo $model->cover_imgpath?>"/>

    </div>
    <div >
        <?php
        foreach ($serial_goods_data as $goods) {
            echo '<div style="display:block;width: 25%;float: left"><img style="width: 100%" src="'.(isset($goods['navigate_image'])?$goods['navigate_image']:'').'"/><div>'.$goods['label_name'].'</div><span style="color:red">'.$goods['suggested_price']/100 .'</span></div>';
        }
        ?>
    </div>

    <?php
    foreach ($serial_contents as $serial_content) {
        echo '<div >
            <img style="width: 100%" src="'.$serial_content['image_path'].'"/>
    
        </div>';
    }
    ?>

</div>
