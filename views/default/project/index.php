<?php
/**
 * 项目列表
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/12/11
 * Time: 13:59
 */
?>

<style>
    .task-wrapper{
        width: 1160px;
        margin: 40px auto;
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        align-items: flex-start;
    }
    .task-item{
        width: 230px;
        height: 180px;
        background: #F37B1D;
        box-shadow: 0 2px 4px 2px #D8D8D8;
        border-radius: 10px;
        text-align: center;
        line-height: 180px;
        color: #fff;
        margin: 30px;
        cursor: pointer;
        transition: all .3s ease-in-out;
    }
    .task-item:hover{
        transform: scale(1.05);
    }
    .am-topbar a{
        color: #fff;
    }
</style>

<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="#"></a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">

        <div class="am-topbar-right">
            <a href="/task/auth/logout" class="am-btn am-btn-default am-topbar-btn am-round am-btn-sm">登出</a>
        </div>

        <div class="am-topbar-right">
            <div class="am-btn am-btn-warning am-topbar-btn am-round am-btn-sm">创建项目</div>
        </div>

        <div class="am-topbar-right">
            <a href="/task/project/my_tasks"  class="am-btn am-btn-secondary am-topbar-btn am-round am-btn-sm">我的任务</a>
        </div>

        <div class="am-topbar-right">
            <a href="/task/project/my_assign" class="am-btn am-btn-primary am-topbar-btn am-round am-btn-sm">我的指派</a>
        </div>

        <div class="am-topbar-right">
            <a href="/task/project/tasks?action=all"  class="am-btn am-btn-success am-topbar-btn am-round am-btn-sm">全部任务</a>
        </div>

    </div>
</header>

<div class="task-wrapper" id="task-pro-wrapper">
    <?php if(isset($data)){ ?>
        <?php foreach ($data as $item){ ?>
            <div class="task-item">
                <a href="/task/project/view?id=<?= $item['id']?>"><p><?= $item['title']?></p></a>
            </div>
        <?php } ?>
    <?php }else{ ?>
        <p class="text-center">暂无数据</p>
    <?php } ?>
</div>

<?= render('default/public/alert')?>

<!--添加项目模态框-->
<div class="am-modal am-modal-prompt" tabindex="-1" id="task-add-project-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">创建项目</div>
        <div class="am-modal-bd">
            <form role="form" id="task-pro-form" class="am-form" action="" onsubmit="return false">
                <input name="title" style="border-radius: 5px" type="text" class="am-modal-prompt-input" placeholder="项目名称~ 如：送车中国官方APP">
                <textarea name="content" rows="5" style="border-radius: 5px;margin-top: 10px" type="text" class="am-modal-prompt-input" placeholder="项目描述~ 如：该项目用于推广送车中国主要业务"></textarea>
            </form>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span id="submit-new-project" class="am-modal-btn" data-am-modal-confirm>提交</span>
        </div>
    </div>
</div>

<?php

echo Asset::css([

]);

echo Asset::js([
    '//cdn.bootcss.com/jquery/3.2.1/jquery.js',
    '//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js',
    'public/public.js',
    'project/index.js'
]);

?>
