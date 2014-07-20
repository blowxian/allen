<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>

    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.6.4.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>js/AjaxUploadImage.js"></script>

    <script>

        function startSmallCallback() {
            $( '#display-cover-image' ).css( 'display', 'block' );
            $( "#display-cover-image" ).css( 'background-image',  "url(img/loading.gif)" );
            return true;
        }

        function completeSmallCallback(response) {
            $( "#display-cover-image" ).css( 'background-image',  "url(<?php echo base_url(); ?>img/product/cover/" + response + ")" );
            $( "#product-cover-image" ).val( response );
        }
    </script>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">添加类目</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li class="select"><a href="javascript:;">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li><a href="<?php echo base_url().'admin/manageproduct/'; ?>">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-category">

            <div id="display-cover-image"></div>

            <form action="<?php echo base_url().'upload/uploadCover/' ?>" enctype="multipart/form-data" method="post" onsubmit="return AIM.submit(this, {'onStart' : startSmallCallback, 'onComplete' : completeSmallCallback});">

                <table>

                    <tfoot>

                        <tr>

                            <td>
                                <input type="submit" value="上传类目封面" style="width: 100px;" />
                            </td>

                        </tr>

                    </tfoot>

                    <tbody>

                        <tr>

                            <td>
                                <input type="file" name="cover-image" style="width: auto;" />
                                <input type="hidden" name="size" value="small" />
                            </td>

                        </tr>

                    </tbody>

                </table>

            </form>

            <?php echo validation_errors(); ?>

            <?php echo form_open('admin/addCategoryToDb'); ?>

                <table>

                    <tfoot>

                        <tr>
                            <td></td>
                            <td><input type="hidden" id="product-cover-image" name="product-cover-image" value="" /></td>
                            <td><input type="submit" value="提交" /></td>
                        </tr>

                    </tfoot>
                    <tbody>

                        <tr>
                            <td><label for="enable-category-cn">启用中文：</label></td>
                            <td class="category-detail-cn"><input type="checkbox" id="enable-category-cn" name="enable-category-cn" checked="true" /></td>
                            <td><label for="enable-category-en">启用英文：</label></td>
                            <td class="category-detail-en"><input type="checkbox" id="enable-category-en" name="enable-category-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="parent-id-cn">父类名称：</label></td>
                            <td class="parent-id-cn">
                                <select name="parent-id-cn">
                                    <option value="0">无</option>
                                    <?php
                                    function genOptionList( $category, $pre = '' ) {
                                        $pre .= '->';

                                        if( count( $category ) > 0 ) {
                                            foreach( $category as $category_item ) {
                                                echo '<option value='.$category_item['category_id'].'>'.$pre.' '.$category_item['category_name'].'</option>';
                                                genOptionList( $category_item['child_category'], $pre );
                                            }
                                        }
                                    }

                                    genOptionList( $category_cn );
                                    ?>
                                </select>
                            </td>
                            <td><label for="parent-id-en">Category Name:</label></td>
                            <td class="parent-id-en">
                                <select name="parent-id-en">
                                    <option value="0">None</option>
                                    <?php
                                    genOptionList( $category_en );
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="category-name-cn">类目名称：</label></td>
                            <td class="category-detail-cn"><input type="text" id="category-name-cn" name="category-name-cn" /></td>
                            <td><label for="category-name-en">Category Name:</label></td>
                            <td class="category-detail-en"><input type="text" id="category-name-en" name="category-name-en" /></td>
                        </tr>
                        <tr>
                            <td><label for="category-desc-cn">类目描述：</label></td>
                            <td class="category-detail-cn"><input type="text" id="category-desc-cn" name="category-desc-cn" /></td>
                            <td><label for="category-desc-en">Category Description:</label></td>
                            <td class="category-detail-en"><input type="text" id="category-desc-en" name="category-desc-en" /></td>
                        </tr>

                    </tbody>
                    
                </table>

            </form>

        </div>
        
    </div>

</body>
</html>