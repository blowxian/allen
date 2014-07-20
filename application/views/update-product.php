<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>

    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.6.4.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>js/AjaxUploadImage.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>js/add-product.js"></script>

    <script>
        function startCallback() {
            $( '#display-large-image' ).css( 'display', 'block' );
            $( "#display-large-image" ).css( 'background-image',  "url(img/loading.gif)" );
            return true;
        }

        function completeCallback(response) {
            $( "#display-large-image" ).css( 'background-image',  "url(<?php echo base_url(); ?>img/product/large/" + response + ")" );
            $( "#product-large-image" ).val( response );
        }

        function startHugeCallback() {
            $( '#display-huge-image' ).css( 'display', 'block' );
            $( "#display-huge-image" ).css( 'background-image',  "url(img/loading.gif)" );
            return true;
        }

        function completeHugeCallback(response) {
            $( "#display-huge-image" ).css( 'background-image',  "url(<?php echo base_url(); ?>img/product/huge/" + response + ")" );
            $( "#product-huge-image" ).val( response );
        }

        function startSmallCallback() {
            $( '#display-small-image' ).css( 'display', 'block' );
            $( "#display-small-image" ).css( 'background-image',  "url(img/loading.gif)" );
            return true;
        }

        function completeSmallCallback(response) {
            $( "#display-small-image" ).css( 'background-image',  "url(<?php echo base_url(); ?>img/product/small/" + response + ")" );
            $( "#product-small-image" ).val( response );
        }
    </script>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">修改产品</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li class="select"><a href="javascript:;">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-product">

            <div id="display-huge-image"></div>

            <form action="<?php echo base_url().'upload/uploadImage/' ?>" enctype="multipart/form-data" method="post" onsubmit="return AIM.submit(this, {'onStart' : startHugeCallback, 'onComplete' : completeHugeCallback});">

                <table>

                    <tfoot>

                    <tr>

                        <td><input type="submit" value="上传放大图片" style="width: 100px;" /></td>

                    </tr>

                    </tfoot>

                    <tbody>

                    <tr>

                        <td>
                            <input type="file" name="product-image" style="width: auto;" />
                            <input type="hidden" name="size" value="huge" />
                        </td>

                    </tr>

                    </tbody>

                </table>

            </form>

            <div id="display-large-image" style="display:block; background-image: url(<?php echo base_url(); ?>img/product/large/<?php echo $product['product_img_large']; ?>);"></div>

            <form action="<?php echo base_url().'upload/uploadImage/' ?>" enctype="multipart/form-data" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback});">

                <table>

                    <tfoot>

                        <tr>

                            <td><input type="submit" value="上传大图片" style="width: 100px;" /></td>

                        </tr>

                    </tfoot>

                    <tbody>

                        <tr>

                            <td>
                                <input type="file" name="product-image" style="width: auto;" />
                                <input type="hidden" name="size" value="large" />
                            </td>

                        </tr>

                    </tbody>

                </table>

            </form>

            <div id="display-small-image" style="display:block; background-image: url(<?php echo base_url(); ?>img/product/small/<?php echo $product['product_img_small']; ?>);"></div>

            <form action="<?php echo base_url().'upload/uploadImage/' ?>" enctype="multipart/form-data" method="post" onsubmit="return AIM.submit(this, {'onStart' : startSmallCallback, 'onComplete' : completeSmallCallback});">

                <table>

                    <tfoot>

                        <tr>

                            <td>
                                <input type="submit" value="上传小图片" style="width: 100px;" />
                            </td>

                        </tr>

                    </tfoot>

                    <tbody>

                        <tr>

                            <td>
                                <input type="file" name="product-image" style="width: auto;" />
                                <input type="hidden" name="size" value="small" />
                            </td>

                        </tr>

                    </tbody>

                </table>

            </form>

            <?php echo validation_errors(); ?>

            <?php echo form_open('admin/updateProductToDb'); ?>

                <table>

                    <tfoot>

                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" id="product-large-image" name="product-large-image" value="<?php echo $product['product_img_large']; ?>" />
                                <input type="hidden" id="product-huge-image" name="product-huge-image" value="<?php echo $product['product_img_huge']; ?>" />
                                <input type="hidden" id="product-small-image" name="product-small-image" value="<?php echo $product['product_img_small']; ?>" />
                                <input type="hidden" name="product-id" value="<?php echo $product['product_id']; ?>" />
                                <input type="hidden" name="product-lang" value="<?php echo $product['product_lang']; ?>" />
                            </td>
                            <td>
                                <input type="submit" value="提交" />
                                <input type="button" value="取消" onclick="window.location='<?php echo base_url().'admin/manageproduct'; ?>'"  />
                            </td>
                        </tr>

                    </tfoot>
                    <tbody>

                        <tr>
                            <td><label for="product-name">名称：</label></td>
                            <td class="product-detail"><input type="text" id="product-name" name="product-name" value="<?php echo $product['product_name']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-no">编号：</label></td>
                            <td class="product-detail"><input type="text" id="product-no" name="product-no" value="<?php echo $product['product_desc'][0]; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-category">类别：</label></td>
                            <td class="product-detail">
                                <select name="product-category">
                                    <?php for( $index = 0, $len = count( $category ); $index < $len; $index++ ) { ?>
                                        <option value="<?php echo $category[$index]['category_id']; ?>" <?php if( $category[$index]['category_id'] == $product['product_category'] ) { echo 'selected="selected"'; } ?> ><?php echo $category[$index]['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="product-price">价格：</label></td>
                            <td class="product-detail"><input type="text" id="product-price" name="product-price" value="<?php echo $product['product_desc'][1]; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="min-book">起订量：</label></td>
                            <td class="product-detail"><input type="text" id="min-book" name="min-book" value="<?php echo $product['product_desc'][2]; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-on-sale">材料：</label></td>
                            <td class="product-detail"><textarea id="product-on-sale" name="product-on-sale"><?php echo $product['product_desc'][3]; ?></textarea></td>
                        </tr>
                        <tr>

                            <td>规格：</td>

                            <td class="product-detail">

                                <table>

                                    <tr>
                                        
                                        <td>SEQ.</td>
                                        <td>NO.</td>
                                        <td>Size</td>
                                        <td>Min</td>
                                        
                                    </tr>
                                    <?php for( $index = 0, $len = count( $product['product_spec'] ) / 3; $index < $len; $index++ ) { ?>
                                    <tr class="product-spec-item">

                                        <td><?php echo chr( 65 + $index ); ?></td>
                                        <td class="spec no"><input type="text" name="spec-no-<?php echo $index; ?>" maxlength="9" value="<?php echo $product['product_spec'][$index * 3]; ?>" /></td>
                                        <td class="spec size"><input type="text" name="spec-size-<?php echo $index; ?>" maxlength="19" value="<?php echo count( $product['product_spec'] ) > 1 ? $product['product_spec'][$index * 3 + 1] : "" ; ?>" /></td>
                                        <td class="spec min"><input type="text" name="spec-min-<?php echo $index; ?>" maxlength="4" value="<?php echo count( $product['product_spec'] ) > 1 ? $product['product_spec'][$index * 3 + 2] : ""; ?>" /></td>

                                    </tr>
                                    <?php } ?>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="button" value="添加一条" onclick="addProductSpec( $('.product-spec-item') );" />
                                            <input type="button" value="清空" onclick="clearProductSpec( $('.product-spec-item') );" />
                                        </td>

                                    </tr>

                                </table>

                            </td>

                        </tr>

                    </tbody>
                    
                </table>

            </form>

        </div>
        
    </div>

</body>
</html>