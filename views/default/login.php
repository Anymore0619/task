<?php
/**
 * 登录页
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/12/11
 * Time: 14:13
 */
?>

<style>
    #task-wrapper{
        max-width: 380px;
        max-height: 500px;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
    }
    #footer{
        position: absolute;
        bottom: 40px;
        left: 0;
        text-align: center;
        color: #888;
        font-size: 15px;
    }
</style>

<div class="am-g" id="task-wrapper">
    <div class="am-input-group am-u-sm-12" style="margin-top: 80px">
        <span class="am-input-group-label am-round"><i class="am-icon-user am-icon-fw"></i></span>
        <input id="task-username" type="text" class="am-form-field am-round" placeholder="用户名">
    </div>
    <div class="am-input-group am-u-sm-12" style="margin-top: 20px">
        <span class="am-input-group-label am-round"><i class="am-icon-lock am-icon-fw"></i></span>
        <input id="task-password" type="password" class="am-form-field am-round" placeholder="密码">
    </div>
    <div class="am-u-sm-12" style="margin-top: 40px">
        <div id="task-login-btn" type="button" class="am-btn am-btn-secondary am-round am-u-sm-12">登录</div>
    </div>
</div>
<div class="am-g" id="footer">
<!--    <p>送车中国任务管理系统</p>-->
</div>

<?= render('default/public/alert')?>

<?php

echo Asset::css([

]);

echo Asset::js([
    '//cdn.bootcss.com/jquery/3.2.1/jquery.js',
    '//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js',
    'public/public.js',
    'login/login.js',
]);

?>










