<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Welcome to Taihe Packing LTD. CO.!</title>

    <?php echo link_tag( 'css/main.css' ); ?>
    <?php echo link_tag( 'css/imageflow.packed.css' ); ?>

    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.6.4.min.js"></script>

    <!-- make html5 markup supported by IE 6, 7 -->
    <script type="text/javascript" src="<?php echo base_url() ?>js/CreateHTML5Elements.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>js/imageflow.js"></script>

</head>
<body>

    <!-- picture ads -->
    <header class="index">

        <div id="myImageFlow" class="imageflow" style="width: 1024px; margin: auto;">
            <?php foreach($slidePhotoList as $slidePhoto) { ?>
                <img src="img/slide/origin/<?=$slidePhoto?>" longdesc="img/slide/origin/<?=$slidePhoto?>" />
            <?php } ?>
        </div>

        <div class="taihe-logo" ></div>

    </header>