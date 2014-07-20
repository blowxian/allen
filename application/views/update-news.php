<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">修改新闻</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li class="select"><a href="javascript:;">管理新闻</a></li>
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

            <?php echo form_open('admin/updateNewsToDb'); ?>

                <table>
                    
                    <tfoot>

                        <tr>

                            <td><input type="hidden" name="news-id" value="<?php echo $news['page_id']; ?>" /></td>
                            <td><input type="submit" value="修改" /><input type="button" value="取消" onclick="window.location='<?php echo base_url().'admin/managenews'; ?>'" /></td>
                            
                        </tr>

                    </tfoot>

                    <tbody>
                    
                        <tr>
                            
                            <td><label for="news-title-cn">标题：</label></td>
                            <td><input type="text" id="news-title" name="news-title" value="<?php echo $news['page_title']; ?>" /></td>

                        </tr>
                        <tr>

                            <td>内容：</td>
                            <td><textarea name="news-content"><?php echo $news['page_content']; ?></textarea></td>

                        </tr>

                    </tbody>
                </table>

            </form>

        </div>
        
    </div>

</body>
</html>