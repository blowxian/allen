

            <div class="news-list">

                <ul>
                    <?php foreach( $news_list as $news ) { ?>
                    <a href="<?php echo base_url().'news/single/'.$news['page_id'].'/'.$lang; ?>"><li><?php echo $news['page_title']; ?></li></a>
                    <?php } ?>
                </ul>

            </div>

        </div>

    </div>
