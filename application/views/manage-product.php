<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="sub-title">管理产品</div>

    <div id="nav">
        <ul class="menu">
            <li><a href="<?php echo base_url().'admin/home/'; ?>">管理主页</a></li>
            <li><a href="<?php echo base_url().'admin/addnews/'; ?>">添加新闻</a></li>
            <li><a href="<?php echo base_url().'admin/managenews/'; ?>">管理新闻</a></li>
            <li><a href="<?php echo base_url().'admin/addcategory/'; ?>">添加类目</a></li>
            <li><a href="<?php echo base_url().'admin/managecategory/'; ?>">管理类目</a></li>
            <li><a href="<?php echo base_url().'admin/addproduct/'; ?>">添加产品</a></li>
            <li class="select"><a href="javascript:;">管理产品</a></li>
        </ul>
    </div>

    <div id="main-port">

        <div class="admin-main" style="text-align: center; margin-bottom: 20px;">
            <label for="search-input">请输入搜索关键字</label><input id="search-input" type="text" value="<?php echo $search; ?>" />
            <input type="button" value="点击搜索" onclick="searchProduct()" />
            <input type="button" value="重置" onclick="reset()" />
        </div>
        <script>
            function searchProduct() {
                var searchStr = document.getElementById( "search-input" ).value;
                self.location = "<?php echo base_url().'admin/manageproduct/1/'; ?>" + searchStr;
            }

            function reset() {
                self.location = "<?php echo base_url().'admin/manageproduct/'; ?>";
            }
        </script>

        <div class="manage-news">

            <table style="text-align: center;">
                <tbody>
                    <tr>
                        <th>产品编号</th>
                        <th>产品名称</th>
                        <th>市场价格</th>
                        <th>产品材料</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach( $product as $product_item ) { ?>
                    <tr>
                        <td><?php $desc = explode( ',', $product_item['product_desc'] ); echo $desc[0]; ?></td>
                        <td><?php echo $product_item['product_name'] ?></td>
                        <td><?php $desc = explode( ',', $product_item['product_desc'] ); echo $desc[1]; ?></td>
                        <td><?php $desc = explode( ',', $product_item['product_desc'] ); echo $desc[2]; ?></td>
                        <td>
                            <input type='button' value="删除" onclick="window.location='<?php echo base_url().'admin/deleteproduct/'.$product_item['product_id']; ?>'" />
                            <input type='button' value="修改" onclick="window.location='<?php echo base_url().'admin/updateproduct/'.$product_item['product_id']; ?>'" />
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php if( $page_sum > 1 ) { ?>

            <div class="paging" style="font-size: 14px; margin-top: 20px;">
                <?php for( $i = 1; $i <= $page_sum; $i++ ) { ?>
                <a <?php if( $page_num != $i ) { echo 'class="enable" href="'.base_url().'admin/manageproduct/'.$i.'/'.$search.'"'; } ?>><?php echo $i; ?></a>
                <?php } ?>
            </div>

            <?php } ?>

        </div>
        
    </div>

</body>
</html>