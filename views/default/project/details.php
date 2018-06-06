<?php
/**
 * 查看工单详情
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/12/12
 * Time: 19:24
 */
?>


<style>
    .task-wrapper {
        width: 1190px;
        margin: 40px auto;
        margin-bottom: 100px;
    }
    p {
        font-size: 14px;
        margin: 0 !important;
        padding: 0 !important;
    }
    .item{
        width: 100%;
        padding: 15px;
        color: #34495e;
        margin-bottom: 20px;
        background: #fff;
        box-shadow: 0 2px 8px 0 #D8D8D8;
        border-radius: 5px;
    }
    .right-item{
        width: 100%;
        padding: 15px;
        color: #34495e;
        margin-bottom: 20px;
        background: #fff;
        box-shadow: 0 2px 8px 0 #D8D8D8;
        border-radius: 5px;
    }
    #task-desc{
        color: #F37B1D;
        font-size: 13px;
        border-radius: 3px;
        margin-bottom: 15px;
    }
    #task-desc p{
        color: #F37B1D;
        font-size: 13px;
        margin: 3px !important;
    }
    #task-desc pre{
        background: #fff;
        border-radius: 3px;
        position: relative;
        border: 1px solid #eee !important;
    }
    #task-desc pre:before{
        font-size: 14px;
        content: 'Code';
        color: #ccc;
        position: absolute;
        top: 10px;
        right: 10px;
    }
    #task-comment div:first-of-type{
        border-top: 1px solid #ddd;
    }
</style>

<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="/project">送车中国工单管理系统</a>
    </h1>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">

        <div class="am-topbar-right">
            <a href="/auth/logout" class="am-btn am-btn-default am-topbar-btn am-round am-btn-sm">登出</a>
        </div>

    </div>
</header>

<div class="task-wrapper">

    <div class="am-g">
        <div class="am-u-sm-9-12">
            <ol class="am-breadcrumb" style="padding-left: 15px;">
                <li><a style="cursor: pointer" id="back-to-task">任务</a></li>
                <li><a href="#">任务详情</a></li>
                <li><a href="#" id="task-no"></a></li>
            </ol>
        </div>

        <div class="am-u-sm-9">
            <div class="item">
                任务标题：<span id="task-title" style="color:#F37B1D;">加载中...</span>
            </div>
            <div class="item">
                任务描述：<article id="task-desc" style="margin-top: 10px;"></article>
            </div>
            <div class="item">
                任务类型：<span id="task-type" style="color:#F37B1D;">加载中...</span>
            </div>
            <div class="item" style="display: flex;flex-flow: row nowrap;justify-content: flex-start;align-items: center;">
                <p style="font-size: 16px;">当前状态：</p>
                <form action="" class="am-form" style="margin-bottom: 0;width: 40%;">
                    <select name="" id="task-status" style="border: 1px solid #eee;border-radius: 5px;color: #F37B1D;">
                        <option style="color: #000;" value="1">待处理</option>
                        <option style="color: #000;" value="2">待测试</option>
                        <option style="color: #000;" value="3">已完成</option>
                        <option style="color: #000;" value="4">已撤销</option>
                    </select>
                </form>
            </div>
            <div class="item">
                @发布人：<span id="task-publisher" style="color:#F37B1D;">加载中...</span>
            </div>
            <div class="item" style="display: flex;flex-flow: row nowrap;justify-content: flex-start;align-items: center;">
                <p style="font-size: 16px;">@指派人：</p>
                <form action="" class="am-form" style="margin-bottom: 0;width: 40%;">
                    <select name="" id="task-to-user" style="border: 1px solid #eee;border-radius: 5px;color: #F37B1D;">
                        <option style="color: #000;" value="" selected disabled>更改指派人</option>
                    </select>
                </form>
            </div>
            <div class="item">
                创建时间：<span id="task-created" style="color:#F37B1D;">加载中...</span>
            </div>
            <div class="item">
                完成时间：<span id="task-end" style="color:#F37B1D;">加载中...</span>
            </div>
        </div>

        <div class="am-u-sm-3">
            <div class="right-item">
                <p style="font-size: 16px;">任务操作历史：</p>
                <article class="am-comment" id="task-comment" style="margin: 8px 0;">

                </article>
            </div>
        </div>
    </div>

</div>

<?= render('default/public/alert')?>

<!--评论模态框-->
<div class="am-modal am-modal-prompt" tabindex="-1" id="task-comment-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">添加评论</div>
        <div class="am-modal-bd">
            <form role="form" id="task-ticket-form" class="am-form" action="" onsubmit="return false">
                <textarea class="" style="border-radius: 5px;margin-top: 10px" rows="5" id="pro-task-comment" placeholder="输入您的描述，可以不写"></textarea>
            </form>
        </div>
        <div class="am-modal-footer">
            <span id="cancel-submit-btn" class="am-modal-btn" data-am-modal-cancel>取消修改</span>
            <span id="submit-comment-btn" class="am-modal-btn" data-am-modal-confirm>提交修改</span>
        </div>
    </div>
</div>

<script id="task-comment-tmpl" type="text/x-jquery-tmpl">
{{each(index, item) logs}}
    <div style="font-size:14px;width: 100%;padding: 5px 0;margin:5px 0;border-bottom: 1px solid #ddd;>
        {{if item.type !== "1"}}
            <div style="color: #999;">
                <span style="color:#F37B1D">${item.user_name}</span><span style="color: #999"> 修改状态为 </span><span style="color:#F37B1D">${item.status_name}</span>
                <p style="color: #999; margin-bottom:0">留言：${item.content}</p>
                <p style="color: #999;margin-left:50px">${item.created_at}</p>
             </div>
        {{/if}}
        {{if item.type === "1"}}
            <div style="color: #999">
                <span style="color:#F37B1D">${item.user_name}</span><span style="color: #999"> 将指派人由 </span><span style="color:#F37B1D">${item.before_parent}</span><span style="color: #999">更改为</span>
                <span style="color:#F37B1D">${item.after_parent}</span>
                <p style="color: #999; margin-bottom:0">留言：${item.content}</p>
                <p style="color: #999;margin-left:50px">${item.created_at}</p>
            </div>
        {{/if}}

    </div>
{{/each}}
</script>

<?php

echo Asset::css([

]);

echo Asset::js([
    '//cdn.bootcss.com/jquery/3.2.1/jquery.js',
    '//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js',
    'lib/jquery.tmpl.min.js',
    'public/public.js',
    'project/details.js',
]);

?>
