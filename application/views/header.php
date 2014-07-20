<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <title><?php echo ${$current.'_name'}; ?> | Taihe Packing LTD. CO.</title>

    <?php echo link_tag( 'css/main.css' ); ?>
    <?php echo link_tag( 'css/pic-zoom.css' ); ?>

    <!-- make html5 markup supported by IE 6, 7 -->
    <script type="text/javascript" src="<?php echo base_url() ?>js/CreateHTML5Elements.js"></script>
</head>
<body>

    <!-- header -->
    <header></header>

    <!-- main -->
    <div id="main">

        <div id="main-wrap">

            <!-- language panel -->

                <nav>
                    <ul>
                        <a href="<?php echo $home_link; ?>"><li<?php echo ' class="'.$home_class.'"'; ?>><?php echo $home_name; ?></li></a>
                        <a href="<?php echo $profile_link; ?>"><li<?php echo ' class="'.$profile_class.'"'; ?>><?php echo $profile_name; ?></li></a>
                        <a href="<?php echo $product_link; ?>"><li<?php echo ' class="'.$product_class.'"'; ?>><?php echo $product_name; ?></li></a>
                        <a href="<?php echo $news_link; ?>"><li<?php echo ' class="'.$news_class.'"'; ?>><?php echo $news_name; ?></li></a>
                        <a href="<?php echo $contact_link; ?>"><li<?php echo ' class="'.$contact_class.'"'; ?>><?php echo $contact_name; ?></li></a>
                    </ul>

                    <div class="clear"></div>
                </nav>

                <!-- fixed firefox bug -->
                <div style="height: 1px;"></div>