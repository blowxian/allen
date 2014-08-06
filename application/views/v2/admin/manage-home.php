<!DOCTYPE html>
<html lang="zh-CN" dropEffect="none" class="no-js ">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>管理后台 | 泰和包装</title>

    <!-- Bootstrap core CSS -->
    <link href="http://v3.bootcss.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/v2/admin-custom.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/jquery.loadmask.css" rel="stylesheet">

    <style>
        body{font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","WenQuanYi Micro Hei",sans-serif;}
        h1, .h1, h2, .h2, h3, .h3, h4, .h4, .lead {font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif;}
        pre code { background: transparent; }
        @media (min-width: 768px) {
            .bs-docs-home .bs-social,
            .bs-docs-home .bs-masthead-links {
                margin-left: 0;
            }
        }

    </style>

</head>
<body>

<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../" class="navbar-brand">泰和网站管理系统</a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">网站整体</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_news">新闻管理</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_category">类目管理</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_product">产品管理</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../about">关于WAX工作室</a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="container bs-docs-container" id="container">
    <div class="row">
        <div class="col-md-3">
            <div class="bs-sidebar hidden-print affix" role="complementary" style="">
                <ul class="nav bs-sidenav" id="sidebar">
                </ul>
            </div>
        </div>

        <div class="col-md-9" role="main">
            <div class="bs-docs-section first" id="view-site" style="display: none;">
                <div class="page-header">
                    <h3 id="news-title-label">整站统计</h3>
                </div>
            </div>

            <!-- S 首页Slide图片列表 -->
            <div class="bs-docs-section first" id="manage-home-pic" style="display: none;">
                <div class="page-header">
                    <h3 id="managenews">首页图片</h3>
                </div>

                <div id="slide-image-container">

                    <div class="row well" id="upload-slide-image-wrap">

                        <div class="col-md-2">
                            <div class="thumbnail" style="margin-bottom:0;" id="slide-image-wrap">
                                <img data-src="holder.js/100x100" style="padding:0; margin:0;">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="input-group">
                                <form id="imageform" method="post" enctype="multipart/form-data" action='../adminApi/upload_slide_image'>
                                    <input type="file" class="form-control" name="slide-image" style="border-top-left-radius: 4px; border-bottom-left-radius: 4px" id="slide-image" />
                                </form>
                            <span class="input-group-btn">
                                <button id="submit-slide-image" class="btn btn-default" type="button"><span class="glyphicon glyphicon-cloud-upload"></span> 上传商品主图</button>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo">添加一张</button>
                        </div>

                    </div>

                    <h4>已添加图片：</h4>

                    <div class="row" id="slide-photo-list">
                    </div>

                </div>
            </div>
            <!-- E 首页Slide图片列表 -->

            <!-- S 首页公司地址列表 -->
            <div class="bs-docs-section first" id="manage-contact" style="display: none;">
                <div class="page-header">
                    <h3>公司联系地址</h3>
                </div>

                <div>
                    <div class="well">
                        <div class="row" id="edit-contact-wrap">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">地址</span>
                                    <input type="text" class="form-control" placeholder="请填写公司地址">
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">邮编</span>
                                    <input type="text" class="form-control" placeholder="请填写邮编">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">固定电话</span>
                                    <input type="text" class="form-control" placeholder="请填写固定电话">
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">传真</span>
                                    <input type="text" class="form-control" placeholder="请填写传真">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">移动电话</span>
                                    <input type="text" class="form-control" placeholder="请填写移动电话">
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">邮箱</span>
                                    <input type="text" class="form-control" placeholder="请填写邮箱">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">网址</span>
                                    <input type="text" class="form-control" placeholder="请填写网址">
                                </div>
                            </div>
                        </div>

                        <br />
                        <div class="input-group pull-right">
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo">添加一条</button>
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo">更新地址</button>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <h4>现有联系地址：</h4>

                    <div class="row" id="contact-list">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Username</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td rowspan="3">1</td>
                          <td colspan="3">Chengxi Industry Distract, Yiwu, Zhejiang, China</td>
                          <td rowspan="3">
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo" style="display:block;margin:0 auto;">编辑</button>
                            <br />
                            <button class="btn btn-danger" type="button" data-action="add-slide-photo" style="display:block;margin:0 auto;">删除</button>
                            </td>
                        </tr>
                        <tr>
                          <td>+86-579-85899138</td>
                          <td>+86-13958418002</td>
                          <td>+86-579-85899355</td>
                        </tr>
                        <tr>
                          <td>322000</td>
                          <td>taihepacking@aliyun.com</td>
                          <td>http://www.taihepacking.com</td>
                        </tr>
                        <tr>
                          <td rowspan="3">2</td>
                          <td colspan="3">Chengxi Industry Distract, Yiwu, Zhejiang, China</td>
                          <td rowspan="3">
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo" style="display:block;margin:0 auto;">编辑</button>
                            </td>
                        </tr>
                        <tr>
                          <td>+86-579-85899138</td>
                          <td>+86-13958418002</td>
                          <td>+86-579-85899355</td>
                        </tr>
                        <tr>
                          <td>322000</td>
                          <td>taihepacking@aliyun.com</td>
                          <td>http://www.taihepacking.com</td>
                        </tr>
                        <tr>
                          <td rowspan="3">3</td>
                          <td colspan="3">Chengxi Industry Distract, Yiwu, Zhejiang, China</td>
                          <td rowspan="3">
                            <button class="btn btn-primary" type="button" data-action="add-slide-photo" style="display:block;margin:0 auto;">编辑</button>
                            </td>
                        </tr>
                        <tr>
                          <td>+86-579-85899138</td>
                          <td>+86-13958418002</td>
                          <td>+86-579-85899355</td>
                        </tr>
                        <tr>
                          <td>322000</td>
                          <td>taihepacking@aliyun.com</td>
                          <td>http://www.taihepacking.com</td>
                        </tr>
                      </tbody>
                    </table>
                    </div>

                </div>
            </div>
            <!-- E 首页Slide图片列表 -->

        </div>
    </div>

</div>

<!-- Template -->
<script type="text/html" id="sidebar-tmpl">
    <%for(var i in menuList) {%>
    <li <%=(i == curMenu) ? 'class="active"' : ''%>>
        <a href="#switchLang" action="switch-tab" tabid="<%=i%>"><%=menuList[i].name%></a>
    </li>
    <%}%>
</script>

<script type="text/html" id="slide-photo-tmpl">
    <div class="slide-photo col-sm-6 col-md-12">
        <div class="thumbnail row">
            <div class="thumbnail col-sm-2" style="width:100px;">
                <img src="../img/slide/100x100/<%=imgURL%>" data-src="holder.js/100x100" alt="<%=imgURL%>" style="margin:0;">
            </div>

            <div class="caption col-sm-10">
                <span class="col-sm-11 slide-image-url"><%=imgURL%></span>
                <span class="col-sm-1">
                    <button class="btn btn-default" type="button" data-action="del-slide-photo">删除</button>
                </span>
            </div>
        </div>
    </div>
</script>

<!-- Core JavaScript -->
<script src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
<script src="<?= base_url() ?>js/jquery.loadmask.min.js"></script>
<script src="http://v3.bootcss.com/dist/js/bootstrap.js"></script>
<script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
<script src="<?= base_url() ?>js/v2/jquery.form.js"></script>
<script src="<?= base_url() ?>js/v2/bootstrap-wysiwyg.js"></script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>

<!-- Custom JavaScript -->
<script src="<?= base_url() ?>js/v2/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        manageHome.init();
    });
</script>

</body>
</html>