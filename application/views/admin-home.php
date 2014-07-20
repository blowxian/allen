<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>

    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.6.4.min.js"></script>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">管理主页</div>

    <div id="nav">
        <ul class="menu">
            <li class="select"><a href="javascript:;">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li><a href="<?php echo base_url().'admin/manageproduct/'; ?>">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-main"></div>
        
    </div>

</body>
</html>