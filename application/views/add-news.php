<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">添加新闻</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li class="select"><a href="javascript:;">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li><a href="<?php echo base_url().'admin/manageproduct/'; ?>">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-main"></div>

        <div class="admin-news">

            <?php echo validation_errors(); ?>

            <?php echo form_open('admin/addNewsToDb'); ?>

                <table>
                    
                    <tfoot>

                        <tr>

                            <td></td>
                            <td></td>
                            <td><input type="submit" value="提交" /></td>
                            
                        </tr>

                    </tfoot>

                    <tbody>

                        <tr>
                            
                            <td><label for="enable-news-cn">启用中文：</label></td>
                            <td><input type="checkbox" id="enable-news-cn" name="enable-news-cn" checked="true" /></td>
                            <td><label for="enable-news-en">启用英文：</label></td>
                            <td><input type="checkbox" id="enable-news-en" name="enable-news-en" /></td>

                        </tr>
                        <tr>
                            
                            <td><label for="news-title-cn">标题：</label></td>
                            <td><input type="text" id="news-title-cn" name="news-title-cn" /></td>
                            <td><label for="news-title-en">Title:</label></td>
                            <td><input type="text" id="news-title-en" name="news-title-en" /></td>

                        </tr>
                        <tr>

                            <td>内容：</td>
                            <td><textarea name="news-content-cn"></textarea></td>
                            <td>Content:</td>
                            <td><textarea name="news-content-en"></textarea></td>

                        </tr>

                    </tbody>
                </table>

            </form>

        </div>
        
    </div>

</body>
</html>