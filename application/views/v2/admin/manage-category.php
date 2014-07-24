<!DOCTYPE html>
<html lang="zh-CN" dropEffect="none" class="no-js ">
<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>管理后台 | 泰和包装</title>

    <!-- Bootstrap core CSS -->
    <link href="http://v3.bootcss.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/v2/admin-custom.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/jquery.loadmask.css" rel="stylesheet">

    <style>
        body {
            font-family: "ff-tisa-web-pro-1", "ff-tisa-web-pro-2", "Lucida Grande", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "WenQuanYi Micro Hei", sans-serif;
        }

        h1, .h1, h2, .h2, h3, .h3, h4, .h4, .lead {
            font-family: "ff-tisa-web-pro-1", "ff-tisa-web-pro-2", "Lucida Grande", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "Microsoft YaHei UI", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
        }

        pre code {
            background: transparent;
        }

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
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_home">网站整体</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_news">新闻管理</a>
                </li>
                <li class="active">
                    <a href="#">类目管理</a>
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

<div class="container bs-docs-container">
    <div class="row">
        <div class="col-md-3">
            <div class="bs-sidebar hidden-print affix" role="complementary" style="">
                <ul class="nav bs-sidenav">
                    <li class="active">
                        <a href="#managecategory">管理类目</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="col-md-9" role="main">
            <div class="bs-docs-section first">
                <div class="page-header">
                    <h3 id="addnews">类目浏览</h3>
                </div>

                <div id="cate-list-wrap" class="well">
                    <div class="row category-title-wrap">
                        <div class="col-md-3 category-title">
                            一级类目
                            <button type="button" class="btn btn-default btn-xs" data-level="1" data-action="render-add">新增</button>
                        </div>
                        <div class="col-md-3 category-title">
                            二级类目
                            <button type="button" class="btn btn-default btn-xs" data-level="2" data-action="render-add">新增</button>
                        </div>
                        <div class="col-md-3 category-title">
                            三级类目
                            <button type="button" class="btn btn-default btn-xs" data-level="3" data-action="render-add">新增</button>
                        </div>
                        <div class="col-md-3 category-title">
                            四级类目
                            <button type="button" class="btn btn-default btn-xs" data-level="4" data-action="render-add">新增</button>
                        </div>
                    </div>

                    <div class="row edit">
                        <div class="well col-md-3 category-list-wrap">
                            <ul class="list-unstyled category-list" id="category-list-level-1">
                            </ul>
                        </div>
                        <div class="well col-md-3 category-list-wrap">
                            <ul class="list-unstyled category-list" id="category-list-level-2">
                            </ul>
                        </div>
                        <div class="well col-md-3 category-list-wrap">
                            <ul class="list-unstyled category-list" id="category-list-level-3">
                            </ul>
                        </div>
                        <div class="well col-md-3 category-list-wrap">
                            <ul class="list-unstyled category-list" id="category-list-level-4">
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="cate-detail-wrap" class="well">
                    <input type="hidden" id="cate-id" value="" />
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">类目标题</button>
                        </span>
                        <input type="text" class="form-control" id="cate-title" />
                        <div class="input-group-btn" id="lang-switch"></div>
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon">类目描述</span>
                        <input type="text" class="form-control" id="cate-desc" />
                    </div>
                    <br />
                    <div id="upload-cate-cover-wrap" class="upload-cate-cover-wrap">
                        <div id="cate-cover-wrap">
                            <img data-src="holder.js/200x200" class="img-rounded img-preview" alt="200x200" style="width: 200px; height: 200px;" id="cate-cover">
                            <input type="hidden" id="cate-cover-url" value="" />
                            <div class="loading-cover" id="cate-cover-loading" style="display: none"></div>
                        </div>
                        <br />
                        <div class="input-group">
                            <form id="imageform" method="post" enctype="multipart/form-data" action='../adminApi/upload_cate_cover'>
                                <input type="file" class="form-control" name="cover-image" id="upload-cate-cover" />
                            </form>
                            <span class="input-group-btn">
                                <button id="submit-cate-cover-image" class="btn btn-default" type="button"><span class="glyphicon glyphicon-cloud-upload"></span> 上传类目封面</button>
                            </span>
                        </div>
                    </div>
                    <br />
                    <button type="button" class="btn btn-default" action="update-news" id="update-category-btn">更新</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Template -->
<script type="text/html" id="lang-switch-tmpl">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><%=langOption[curLang]%> <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <%for(var i in langOption) {
            if(i != curLang) {%>
        <li><a href="#switchLang" action="switch-lang" langid="<%=i%>"><%=langOption[i]%></a></li>
        <%  }
        }%>
    </ul>
</script>

<script type="text/html" id="category-list-tmpl">
    <%for(var i in categoryList) {%>
    <li <%=categoryList[i].selected ? 'class="selected"' : ''%> data-cateid=<%=categoryList[i].category_id%> data-cateno=<%=i%> data-level=<%=level%> <%=categoryList[i].selected ? '' : 'data-action="select"'%>>
        <%=categoryList[i].category_name%>
        <span class="glyphicon glyphicon-remove-circle" data-cateid="<%=categoryList[i].category_id%>" data-action="delete"></span>
        <%='children' in categoryList[i] ? '<span class="glyphicon glyphicon-play"></span>' : ''%>
    </li>
    <%}%>
</script>

<script type="text/html" id="add-category-tmpl">
    <li class="edit">
        <div class="input-group">
            <input type="text" class="form-control input-sm" id="add-category-level-<%=level%>" />
            <span class="input-group-btn">
                <button class="btn btn-default btn-sm" type="button" data-action="add" data-level="<%=level%>">添加</button>
            </span>
        </div>
    </li>
</script>

<!-- Core JavaScript -->
<script src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
<script src="<?= base_url() ?>js/jquery.loadmask.min.js"></script>
<script src="http://v3.bootcss.com/dist/js/bootstrap.js"></script>
<script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
<script src="<?= base_url() ?>js/v2/bootstrap-wysiwyg.js"></script>
<script src="<?= base_url() ?>js/v2/jquery.form.js"></script>

<!-- Custom JavaScript -->
<script src="<?= base_url() ?>js/v2/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        manageCategory.init();
    });
</script>

</body>
</html>