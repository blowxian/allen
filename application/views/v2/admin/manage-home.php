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

            <div class="bs-docs-section first" id="manage-home-pic" style="display: none;">
                <div class="page-header">
                    <h3 id="managenews">首页图片</h3>
                </div>
            </div>
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

<script type="text/html" id="lang-switch-tmpl">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><%=langOption[curLang]%> <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <%for(var i in langOption) {
            if(i != curLang) {%>
        <li><a href="#" action="switch-lang" langid="<%=i%>"><%=langOption[i]%></a></li>
        <%  }
        }%>
    </ul>
</script>

<script type="text/html" id="news-list-tmpl">
<%for(var i in newsList) {%>
<tr>
        <td><%=~~i + 1%></td>
        <td><%=newsList[i].page_title%></td>
        <td><%=newsList[i].update_time%></td>
        <td>
            <button type="button" class="btn btn-default btn-xs" action="edit-news" newsid="<%=newsList[i].page_id%>">修改</button>
            <button type="button" class="btn btn-default btn-xs" action="del-news" newsid="<%=newsList[i].page_id%>">删除</button>
        </td>
    </tr>
<%}%>
</script>

<!-- Core JavaScript -->
<script src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
<script src="<?= base_url() ?>js/jquery.loadmask.min.js"></script>
<script src="http://v3.bootcss.com/dist/js/bootstrap.js"></script>
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