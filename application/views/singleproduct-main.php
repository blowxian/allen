
            <div class="single-product">

                <?php require_once( 'site-trace.php' ); ?>

                <div class="product-img-large" >

                    <div class="jqzoom">
                        <img src="<?php echo base_url().'img/product/large/'.$product_img_large; ?>" alt="产品放大" jqimg="<?php echo $product_img_huge != '' ? base_url().'img/product/huge/'.$product_img_huge : '' ?>" />
                    </div>

                </div>

                <div class="product-detail">

                    <div class="description">

                        <table>
                            <thead><?php echo $description; ?></thead>
                            <tr>
                                <th>Name :</th>
                                <td><?php echo $product_title; ?></td>
                            </tr>
                            <tr>
                                <th>NO. :</th>
                                <td><?php echo $product_desc[0]; ?></td>
                            </tr>
                            <tr>
                                <th>Unit Price :</th>
                                <td><?php echo $product_desc[1]; ?></td>
                            </tr>
                            <tr>
                                <th>MOQ :</th>
                                <td><?php echo $product_desc[2]; ?></td>
                            </tr>
                            <tr>
                                <th>Material :</th>
                                <td><?php echo $product_desc[3]; ?></td>
                            </tr>
                        </table>

                    </div>

                    <div class="specification">

                        <table>
                            <thead><?php echo $specification; ?></thead>
                            <tr>
                                <th>SEQ.</th>
                                <th>NO.</th>
                                <th>Size</th>
                                <th>Unit Price</th>
                            </tr>
                            <?php
                            $index = 0;
                            $flag = true;

                            while( isset( $product_spec[$index * 3 + 1] ) ) {
                            ?>
                            <tr class="<?php echo $flag ? 'odd' : ''; $flag = !$flag; ?>">
                                <th><?php echo chr(65 + $index); ?></th>
                                <td><?php echo $product_spec[$index * 3]; ?></td>
                                <td><?php echo $product_spec[$index * 3 + 1]; ?></td>
                                <td><?php echo $product_spec[$index * 3 + 2]; ?></td>
                            </tr>
                            <?php
                                $index++;
                            }
                            ?>
                        </table>

                    </div>

                </div>

                <div class="clear"></div>

            </div>

        </div>

    </div>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/product.js" ></script>
