<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>
    <link href="http://v3.bootcss.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/jquery.loadmask.css" rel="stylesheet">
    <style>
        *{margin:0;padding: 0;}
        body{background: #444 url(http://sandbox.runjs.cn/uploads/rs/418/nkls38xx/carbon_fibre_big.png)}
        .loginBox{width:420px;height:230px;padding:0 5px;border:1px solid #fff; color:#000; margin-top:40px; border-radius:8px;background: white;box-shadow:0 0 15px #222; background: -moz-linear-gradient(top, #fff, #efefef 8%);background: -webkit-gradient(linear, 0 0, 0 100%, from(#f6f6f6), to(#f4f4f4));font:11px/1.5em 'Microsoft YaHei' ;position: absolute;left:50%;top:50%;margin-left:-210px;margin-top:-115px;}
        .loginBox h2{height:45px;font-size:20px;font-weight:normal;}
        .loginBox .left{border-right:1px solid #ccc;height:100%;padding-right: 20px; }
        .loginBox .minor{color:#999;}
    </style>
</head>
<body>

    <section class="loginBox container" id = "login-box">
        <section class="col-md-7 left">
            <h2>泰和包装管理后台登录</h2>
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">用户名</label>
                <input type="text" class="form-control" id="username" placeholder="用户名">
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">密码</label>
                <input type="password" class="form-control" id="password" placeholder="密码">
            </div>
            <section class="row">
                <div class="checkbox col-xs-8">
                    <!-- 暂不使用 -->
                    <label style="display: none;">
                        <input type="checkbox">下次自动登录
                    </label>
                </div>
                <div class="col-xs-4"><input type="button" id="login-button" value=" 登录 " class="btn btn-primary"></div>
            </section>
        </section>
        <section class="col-md-5 right minor">
            <h2>使用过程中发现问题？</h2>
            <div>
                <p>使用系统过程中遇到问题可以直接发邮件至2431459755@qq.com，咨询相关解决方案。</p>
            </div>
        </section>
    </section><!-- /loginBox -->

    <!-- Core JavaScript -->
    <script src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
    <script src="<?= base_url() ?>js/jquery.loadmask.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="<?= base_url() ?>js/v2/login.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            window.login.init();
        });
    </script>
</body>
</html>