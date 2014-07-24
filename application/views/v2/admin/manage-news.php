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
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_home">网站整体</a>
                </li>
                <li class="active">
                    <a href="#">新闻管理</a>
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

            <li class="active">
                <a href="#" action="switch-tab" tabid="manageNews">管理新闻</a>
            </li>
            <li>
                <a href="#" action="switch-tab" tabid="addNews">新增新闻</a>
            </li>

        </ul>
    </div>
</div>

<div class="col-md-9" role="main">
    <div class="bs-docs-section first" id="add-news" style="display: none;">
        <div class="page-header">
            <h3 id="news-title-label">新增新闻</h3>
        </div>

        <div class="well" id="news-content-wrap">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">新闻标题</button>
                </span>
                <input type="text" class="form-control" id="news-title" />
                <div class="input-group-btn" id="lang-switch"></div>
            </div>

            <!-- Core Toolbar -->
            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#news-editor">
                <div class="btn-group">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="glyphicon glyphicon-font"></i><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    </ul>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="glyphicon glyphicon-text-height"></i>&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                        <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                        <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="glyphicon glyphicon-bold"></i></a>
                    <a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="glyphicon glyphicon-italic"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="glyphicon glyphicon-list"></i></a>
                    <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="glyphicon glyphicon-sort-by-order"></i></a>
                    <a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="glyphicon glyphicon-indent-right"></i></a>
                    <a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="glyphicon glyphicon-indent-left"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="glyphicon glyphicon-align-left"></i></a>
                    <a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="glyphicon glyphicon-align-center"></i></a>
                    <a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="glyphicon glyphicon-align-right"></i></a>
                    <a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="glyphicon glyphicon-align-justify"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="glyphicon glyphicon-circle-arrow-left"></i></a>
                    <a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </div>
            </div>

            <div id="news-editor">
                编辑新闻
            </div>

            <div style="margin-top: 10px">
                <button type="button" class="btn btn-default" action="save-news" id="save-news-btn">保存</button>
                <button type="button" class="btn btn-default" action="update-news" style="display: none" id="update-news-btn">更新</button>
            </div>
        </div>
    </div>

    <div class="bs-docs-section first" id="manage-news" style="display: none;">
        <div class="page-header">
            <h3 id="managenews">管理新闻</h3>
        </div>

        <div class="well" id="news-list-wrap">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>新闻标题</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="news-list">
                <tr>
                    <td colspan="4" class="text-center">无记录</td>
                </tr>
                </tbody>
            </table>
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
<script src="<?= base_url() ?>js/v2/admin.js"></script>

<!-- Custom JavaScript -->
<script src="<?= base_url() ?>js/v2/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        manageNews.init();
    });
</script>

</body>
</html>