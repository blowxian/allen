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
    <link href="<?= base_url() ?>css/v2/jqpagination.css" rel="stylesheet">

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
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_news">新闻管理</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>adminDev/manage_category">类目管理</a>
                </li>
                <li class="active">
                    <a href="#">产品管理</a>
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
                        <a href="#manageproduct" data-action="switch-tab" tabid="manageProduct">管理商品</a>
                    </li>
                    <li class="">
                        <a href="#addproduct" data-action="switch-tab" tabid="addProduct">新增商品</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="col-md-9" role="main">
            <div class="bs-docs-section first" id="add-product" style="display: none">
                <div class="page-header">
                    <h3 id="addproduct">新增商品</h3>
                </div>

                <div class="well" id="add-product-main">

                    <input type="hidden" id="product-id" />
                    <div class="input-group">
                        <span class="input-group-addon">商品名称</span>
                        <input type="text" class="form-control" id="product-name" />
                        <div class="input-group-btn" id="lang-switch"></div>
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon">商品编号</span>
                        <input type="text" class="form-control" id="product-no" />
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon">商品价格</span>
                        <input type="text" class="form-control" id="product-price" />
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon">起订量</span>
                        <input type="text" class="form-control" id="product-moq" />
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon">商品材料</span>
                        <input type="text" class="form-control" id="product-material" />
                    </div>

                    <hr />

                    <div id="upload-product-image-wrap" class="upload-product-image-wrap">
                        <div id="product-image-wrap">
                            <img data-src="holder.js/500x500" class="img-rounded img-preview" alt="500x500" style="width: 500px; height: 500px;">
                            <img data-src="holder.js/200x200" class="img-rounded img-preview" alt="140x140" style="width: 200px; height: 200px;">
                            <input type="hidden" id="product-image-url" name="product-image" value="" />
                            <input type="hidden" id="product-small-image-url" name="product-small-image" value="" />
                            <div class="loading-cover" id="cate-cover-loading" style="display: none"></div>
                        </div>
                        <br />
                        <div class="input-group">
                            <form id="imageform" method="post" enctype="multipart/form-data" action='../adminApi/upload_product_image'>
                                <input type="file" class="form-control" name="product-image" style="border-top-left-radius: 4px; border-bottom-left-radius: 4px" id="upload-product-image" />
                            </form>
                            <span class="input-group-btn">
                                <button id="submit-product-image" class="btn btn-default" type="button"><span class="glyphicon glyphicon-cloud-upload"></span> 上传商品主图</button>
                            </span>
                        </div>
                        <br />
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            建议上传500x500的图片，200x200图片将自动生成
                        </div>
                    </div>

                    <hr />

                    <div class="input-group">
                        <input type="text" id="selected-category-trace" class="form-control" disabled>
                        <input type="hidden" id="selected-category-id" name="selected-category" value="" />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="trigger-category-selector"><span class="glyphicon glyphicon-align-justify"></span> 选择商品类目 <span class="caret"></span></button>
                        </span>
                    </div>

                    <div id="cate-selector-wrap">
                        <br />
                        <div id="cate-list-wrap" class="well">
                            <div class="row category-title-wrap">
                                <div class="col-md-3 category-title">
                                    一级类目
                                </div>
                                <div class="col-md-3 category-title">
                                    二级类目
                                </div>
                                <div class="col-md-3 category-title">
                                    三级类目
                                </div>
                                <div class="col-md-3 category-title">
                                    四级类目
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

                        <button class="btn btn-default" type="button" data-action="confirm-category">确认</button>
                        <button class="btn btn-default" type="button" data-action="cancel-category">取消</button>

                    </div>

                    <hr />
                    <h5>商品规格</h5>
                    <table class="table table-condensed text-center product-spec" id="product-spec">
                        <thead>
                        <tr>
                            <th>NO.</th>
                            <th>Size</th>
                            <th>Unit Prize</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input class="form-control input-sm product-spec-item" type="text"></td>
                            <td><input class="form-control input-sm product-spec-item" type="text"></td>
                            <td><input class="form-control input-sm product-spec-item" type="text"></td>
                            <td><span class="glyphicon glyphicon-remove-circle" style="visibility: hidden"></span></td>
                        </tr>
                        </tbody>
                    </table>
                    <br />
                    <button class="btn btn-default" type="button" data-action="add-product-spec">添加一条</button>
                    <input type="hidden" name="product-spec" value="" />
                    <hr />
                    <button class="btn btn-primary" id="create-product-button" type="button" data-action="create-product" style="display: none">创建商品</button>
                    <button class="btn btn-primary" id="update-modified-product-button" type="button" data-action="update-modified-product" style="display: none">更新商品</button>
                </div>
            </div>

            <div class="bs-docs-section first" id="manage-product" style="display: none">
                <div class="page-header">
                    <h3 id="manageproduct">管理商品</h3>
                </div>

                <ul class="nav nav-tabs nav-justified" id="product-search-tab">
                    <li class="active"><a href="#switch-product-search-tab" data-action="switch-product-search-tab" tabid="byKeyword">通过关键字查找商品</a></li>
                    <li><a href="#switch-product-search-tab" data-action="switch-product-search-tab" tabid="byCategory">通过类目查找商品</a></li>
                </ul>

                <br />

                <!--<div id="search-product-by-category" style="display: none;">
                    <div id="cate-list-wrap" class="well">
                        <div class="row category-title-wrap">
                            <div class="col-md-3 category-title">
                                一级类目
                            </div>
                            <div class="col-md-3 category-title">
                                二级类目
                            </div>
                            <div class="col-md-3 category-title">
                                三级类目
                            </div>
                            <div class="col-md-3 category-title">
                                四级类目
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
                </div>-->

                <br />

                <div class="input-group" id="search-product-by-keyword" style="display: none;">
                    <input type="text" class="form-control" id="keyword">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" data-action="query-product-by-keyword"><span class="glyphicon glyphicon-search"></span> 搜索商品</button>
                    </span>
                </div>

                <br />

                <div class="well" id="query-product-result" style="display: none">
                    <h4>查询结果</h4>
                    <hr />
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>商品名称</th>
                            <th>商品编号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="query-product-result-list">
                        </tbody>
                    </table>
                    <div id="query-product-pagination" style="text-align:center">
                        <div class="pagination">
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                    </div>
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
        <li><a href="#" data-action="switch-lang" langid="<%=i%>"><%=langOption[i]%></a></li>
        <%  }
        }%>
    </ul>
</script>

<script type="text/html" id="sidebar-tmpl">
    <%for(var i in menuList) {%>
    <li <%=(i == curMenu) ? 'class="active"' : ''%> <%=(i != curMenu && i == 'modifyProduct') ? 'style="display: none;"' : ''%>>
        <a href="#switchTab" data-action="switch-tab" tabid="<%=i%>"><%=menuList[i].name%></a>
    </li>
    <%}%>
</script>

<script type="text/html" id="switch-product-search-tab-tmpl">
    <%for(var i in tabList) {%>
    <li <%=(i == curTab) ? 'class="active"' : ''%>>
        <a href="#switch-product-search-tab" data-action="switch-product-search-tab" tabid="<%=i%>"><%=tabList[i].name%></a>
    </li>
    <%}%>
</script>

<script type="text/html" id="category-list-tmpl">
    <%for(var i in categoryList) {%>
    <li <%=categoryList[i].selected ? 'class="selected"' : ''%> data-cateid=<%=categoryList[i].category_id%> data-cateno=<%=i%> data-level=<%=level%> <%=categoryList[i].selected ? '' : 'data-action="select"'%>>
        <%=categoryList[i].category_name%>
        <%='children' in categoryList[i] ? '<span class="glyphicon glyphicon-play"></span>' : ''%>
    </li>
    <%}%>
</script>

<script type="text/html" id="product-spec-tmpl">
    <tr>
        <td><input class="form-control input-sm product-spec-item" type="text" value="<%=productNo%>"></td>
        <td><input class="form-control input-sm product-spec-item" type="text" value="<%=productSize%>"></td>
        <td><input class="form-control input-sm product-spec-item" type="text" value="<%=productUnitPrice%>"></td>
        <td><span class="glyphicon glyphicon-remove-circle" data-action="remove-product-spec"></span></td>
    </tr>
</script>

<script type="text/html" id="query-product-result-tmpl">
    <% for(var i in queryResult) { %>
    <tr>
        <td><%=(~~i + 1 + (~~pageNum - 1) * ~~pageSize)%></td>
        <td><%=queryResult[i].product_name%></td>
        <td><%=queryResult[i].product_desc.split(',')[0]%></td>
        <td>
            <button type="button" class="btn btn-default btn-xs" data-pid="<%=queryResult[i].product_id%>" data-action="modify-product">修改</button>
            <button type="button" class="btn btn-default btn-xs" data-pid="<%=queryResult[i].product_id%>" data-action="delete-product">删除</button>
        </td>
    </tr>
    <% } %>
</script>

<!-- Core JavaScript -->
<script src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
<script src="<?= base_url() ?>js/jquery.loadmask.min.js"></script>
<script src="http://v3.bootcss.com/dist/js/bootstrap.js"></script>
<script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
<script src="<?= base_url() ?>js/v2/bootstrap-wysiwyg.js"></script>
<script src="<?= base_url() ?>js/v2/jquery.form.js"></script>
<script src="<?= base_url() ?>js/v2/jquery.jqpagination.min.js"></script>

<!-- Custom JavaScript -->
<script src="<?= base_url() ?>js/v2/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        manageProduct.init();
    });
</script>

</body>
</html>