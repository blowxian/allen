
            <div class="product-list">

                <?php require_once( 'site-trace.php' ); ?>

                <?php if( !$is_product ) { foreach( $category as $category_item ) { ?>

                <a href="<?php echo base_url().'product/category/'.$category_item['category_id'].'/'.$lang; ?>">
                    <div class="product">

                        <h4><?php echo $category_item['category_name']; ?></h4>
                        <div class="product-img" alt="<?php echo $category_item['category_desc']; ?>" style="background-image: url('<?php $img_url = $category_item['category_cover'] ? 'img/product/cover/'.$category_item['category_cover'] : 'img/product/error-'.$lang; echo base_url().$img_url; ?>')"><div class="product-img-mash"></div></div>

                    </div>
                </a>

                <?php }
                } else {
                    if( $product_list == false ) { ?>

                <div class="error-msg">
                    <?php if( $lang == "en" ) { ?>Sorry, No Product Under This Category！<?php } else { ?>对不起，当前目录暂无产品！<?php } ?>
                </div>

                <?php } else {
                        foreach( $product_list as $product ) { ?>

                <a href="<?php echo base_url().'product/single/'.$category_id.'/'.$product['product_id'].'/'.$lang; ?>">
                    <div class="product">

                        <h4><?php echo $product['product_name']; ?></h4>
                        <div class="product-img" style="background-image: url('<?php $img_url = $product['product_img_small'] ? 'img/product/small/'.$product['product_img_small'] : 'img/product/error-'.$lang.'.png'; echo base_url().$img_url; ?>')"><div class="product-img-mash"></div></div>

                    </div>
                </a>

                <?php   }
                    }
                } ?>

                <div class="clear"></div>

                <?php if( $page_sum > 1 ) { ?>

                <div class="paging">
                    <?php for( $i = 1; $i <= $page_sum; $i++ ) { ?>
                        <a <?php if( $page_num != $i ) { echo 'class="enable" href="'.base_url().'product/category/'.$category_id.'/'.$lang.'/'.$i.'"'; } ?>><?php echo $i; ?></a>
                    <?php } ?>
                </div>

                <?php } ?>

                <?php if( $page_num > 1 ) { ?>
                <div class="prev-page">
                    <a class="button" href="<?php echo base_url().'product/category/'.$category_id.'/'.$lang.'/'.( $page_num - 1 ); ?>"></a>
                </div>
                <?php } ?>

                <?php if( $page_num < $page_sum ) { ?>
                <div class="next-page">
                    <a class="button" href="<?php echo base_url().'product/category/'.$category_id.'/'.$lang.'/'.( $page_num + 1 ); ?>"></a>
                </div>
                <?php } ?>

            </div>

        </div>
        
    </div>