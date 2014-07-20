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

    <div id="sub-title">添加产品</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li class="select"><a href="javascript:;">添加产品</a></li>
            <li><a href="<?php echo base_url().'admin/manageproduct/'; ?>">管理产品</a></li>
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

            <div id="display-large-image"></div>

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

            <div id="display-small-image"></div>

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

            <?php echo form_open('admin/addProductToDb'); ?>

                <table>

                    <tfoot>

                        <tr>
                            <td></td>
                            <td><input type="hidden" id="product-large-image" name="product-large-image" value="" /><input type="hidden" id="product-huge-image" name="product-huge-image" value="" /><input type="hidden" id="product-small-image" name="product-small-image" value="" /></td>
                            <td><input type="submit" value="提交" /></td>
                        </tr>

                    </tfoot>
                    <tbody>

                        <tr>
                            <td><label for="enable-product-cn">启用中文：</label></td>
                            <td class="product-detail-cn"><input type="checkbox" id="enable-product-cn" name="enable-product-cn" checked="true" /></td>
                            <td><label for="enable-product-en">启用英文：</label></td>
                            <td class="product-detail-en"><input type="checkbox" id="enable-product-en" name="enable-product-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-name-cn">名称：</label></td>
                            <td class="product-detail-cn"><input type="text" id="product-name-cn" name="product-name-cn" /></td>
                            <td><label for="product-name-en">Name:</label></td>
                            <td class="product-detail-en"><input type="text" id="product-name-en" name="product-name-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-no-cn">编号：</label></td>
                            <td class="product-detail-cn"><input type="text" id="product-no-cn" name="product-no-cn" /></td>
                            <td><label for="product-no-en">No:</label></td>
                            <td class="product-detail-en"><input type="text" id="product-no-en" name="product-no-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-category-cn">类别：</label></td>
                            <td class="product-detail-cn">
                                <select name="product-category-cn">
                                    <?php for( $index = 0, $len = count( $category_cn ); $index < $len; $index++ ) { ?>
                                        <option value="<?php echo $category_cn[$index]['category_id']; ?>"><?php echo $category_cn[$index]['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><label for="product-category-en">Category:</label></td>
                            <td class="product-detail-en">
                                <select name="product-category-en">
                                    <?php for( $index = 0, $len = count( $category_en ); $index < $len; $index++ ) { ?>
                                        <option value="<?php echo $category_en[$index]['category_id']; ?>"><?php echo $category_en[$index]['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="product-price-cn">价格：</label></td>
                            <td class="product-detail-cn"><input type="text" id="product-price-cn" name="product-price-cn" /></td>
                            <td><label for="product-price-en">Price:</label></td>
                            <td class="product-detail-en"><input type="text" id="product-price-en" name="product-price-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="min-book-cn">起订量：</label></td>
                            <td class="product-detail-cn"><input type="text" id="min-book-cn" name="min-book-cn" /></td>
                            <td><label for="min-book-en">MOQ:</label></td>
                            <td class="product-detail-en"><input type="text" id="min-book-en" name="min-book-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="product-on-sale-cn">材料：</label></td>
                            <td class="product-detail-cn"><textarea id="product-on-sale-cn" name="product-on-sale-cn" ></textarea></td>
                            <td><label for="product-on-sale-en">Material:</label></td>
                            <td class="product-detail-en"><textarea id="product-on-sale-en" name="product-on-sale-en"></textarea></td>
                        </tr>
                        <tr>

                            <td>规格：</td>

                            <td class="product-detail-cn">

                                <table>

                                    <tr>
                                        
                                        <td>SEQ.</td>
                                        <td>NO.</td>
                                        <td>Size</td>
                                        <td>Unit Price</td>
                                        
                                    </tr>
                                    <tr class="product-spec-item-cn">

                                        <td>A</td>
                                        <td class="spec no"><input type="text" name="spec-no-cn-0" maxlength="9" /></td>
                                        <td class="spec size"><input type="text" name="spec-size-cn-0" maxlength="19" /></td>
                                        <td class="spec min"><input type="text" name="spec-min-cn-0" maxlength="4" /></td>

                                    </tr>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td><input type="button" value="添加一条" onclick="addCnProductSpec( $('.product-spec-item-cn') );" /></td>

                                    </tr>

                                </table>

                            </td>

                            <td>Specification:</td>

                            <td class="product-detail-en">

                                <table>

                                    <tr>

                                        <td>SEQ.</td>
                                        <td>NO.</td>
                                        <td>Size</td>
                                        <td>Unit Price</td>

                                    </tr>
                                    <tr class="product-spec-item-en">

                                        <td>A</td>
                                        <td class="spec no"><input type="text" name="spec-no-en-0" maxlength="9" /></td>
                                        <td class="spec size"><input type="text" name="spec-size-en-0" maxlength="19" /></td>
                                        <td class="spec min"><input type="text" name="spec-min-en-0" maxlength="4" /></td>

                                    </tr>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td><input type="button" value="add one" onclick="addEnProductSpec( $('.product-spec-item-en') );" /></td>

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