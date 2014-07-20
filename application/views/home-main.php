
    <!-- main -->
    <div id="main" class="index">

        <!-- language panel -->
        <div class="lang-panel"><a href="<?php echo $lang != 'en' ? base_url()."$current/$method/en" : "javascript:;"; ?>">English</a> | <a href="<?php echo $lang != 'en' ? "javascript:;" : base_url()."$current/$method/cn"; ?>">繁體中文</a></div>

        <div id="main-wrap">

            <nav>
                <ul>
                    <a href="<?php echo $home_link; ?>"><li><?php echo $home_name; ?></li></a>
                    <a href="<?php echo $profile_link; ?>"><li><?php echo $profile_name; ?></li></a>
                    <a href="<?php echo $product_link; ?>"><li><?php echo $product_name; ?></li></a>
                    <a href="<?php echo $news_link; ?>"><li><?php echo $news_name; ?></li></a>
                    <a href="<?php echo $contact_link; ?>"><li><?php echo $contact_name; ?></li></a>
                </ul>
            </nav>

            <div class="clear"></div>

            <div class="news-list">

                <caption><h3><?php echo $recently_news; ?></h3></caption>

                <ul>
                    <?php foreach( $news_list as $news ) { ?>
                    <li><a href="<?php echo base_url().'news/single/'.$news['page_id'].'/'.$lang; ?>"><?php echo $news['page_title']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

        </div>

    </div>
    <!-- End of main -->