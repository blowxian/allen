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
            $( "#category-cover-image" ).val( response );
        }
    </script>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">修改类目</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li class="select"><a href="javascript:;">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li><a href="<?php echo base_url().'admin/manageproduct/'; ?>">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-category">

            <div id="display-cover-image" style="display:block; background-image: url(<?php echo base_url(); ?>img/product/cover/<?php echo $category['category_cover']; ?>);"></div>

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

            <?php echo form_open('admin/updateCategoryToDb'); ?>

                <table>

                    <tfoot>

                        <tr>
                            <td>
                                <input type="hidden" id="category-cover-image" name="category-cover-image" value="<?php echo $category['category_cover']; ?>" />
                                <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>" />
                            </td>
                            <td>
                                <input type="submit" value="提交" />
                                <input type="button" value="取消" onclick="window.location='<?php echo base_url().'admin/managecategory'; ?>'" />
                            </td>
                        </tr>

                    </tfoot>
                    <tbody>

                        <tr>
                            <td><label for="parent-id">父类名称：</label></td>
                            <td class="parent-id">
                                <select name="parent-id">
                                    <option value="0">无</option>
                                    <?php
                                    function genOptionList( $parent_category, $category_id, $pre = '' ) {
                                        $pre .= '-';

                                        if( count( $parent_category ) > 0 ) {
                                            foreach( $parent_category as $category_item ) {
                                                if( $category_id == $category_item['category_id'] ) {
                                                    $default = ' selected';
                                                } else {
                                                    $default = '';
                                                }
                                                echo '<option value='.$category_item['category_id'].''.$default.'>'.$pre.' '.$category_item['category_name'].'</option>';
                                                genOptionList( $category_item['child_category'], $category_id, $pre );
                                            }
                                        }
                                    }

                                    genOptionList( $parent_category, $category['parent_id'] );
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="category-name">类目名称：</label></td>
                            <td class="category-detail"><input type="text" id="category-name" name="category-name" value="<?php echo $category['category_name']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="category-desc">类目描述：</label></td>
                            <td class="category-detail"><input type="text" id="category-desc" name="category-desc" value="<?php echo $category['category_desc']; ?>" /></td>
                        </tr>

                    </tbody>
                    
                </table>

            </form>

        </div>
        
    </div>

</body>
</html>