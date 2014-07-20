<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>泰和包装管理后台</title>

    <?php echo link_tag( 'css/admin.css' ); ?>
</head>
<body>

    <div id="login-title">泰和网站管理后台</div>

    <div id="login-frame">
        
        <div style="height:1px;"></div>

        <?php echo validation_errors(); ?>

        <?php echo form_open(base_url().'admin/checkLogin'); ?>

            <table>

                <tbody>

                    <tr>
                        <td><label for="user">用户名：</label></td>
                        <td><input id="user" class="input" name="user" type="text" /></td>
                    </tr>
                    <tr>
                        <td><label for="pwd">密码：</label></td>
                        <td><input id="pwd" class="input" name="pwd" type="password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right;"><input class="submit" name="submit" type="submit" value="登入" /></td>
                    </tr>

                </tbody>

            </table>

        </form>

    </div>

</body>
</html>