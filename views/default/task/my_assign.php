<?php
/**
 * Created By SangShaofeng
 * Date 2017/12/26
 */
?>

<style>
    body{
        height: 100%;
    }
    .task-wrapper{
        width: 1300px;
        margin: 50px auto;
    }
</style>

<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="/project">送车中国任务管理系统</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">

        <div class="am-topbar-right">
            <a href="/auth/logout" class="am-btn am-btn-default am-topbar-btn am-round am-btn-sm">登出</a>
        </div>

    </div>
</header>

<div class="task-wrapper">
    <ol class="am-breadcrumb">
        <li><a href="/project">项目</a></li>
        <li><a href="#" id="task-my-assign">我的指派</a></li>
        <li><a href="#">任务列表</a></li>
    </ol>
    <table class="am-table am-table-hover">
        <thead>
        <tr>
            <th>任务单号</th>
            <th>任务类型</th>
            <th>所属项目</th>
            <th>标题</th>
            <th>发布人</th>
            <th>指派人</th>
            <th>当前状态</th>
            <th>提交时间</th>
            <th>完成时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="task-my-assign-table">

        </tbody>
    </table>
    <?= render('default/public/pagination')?>
</div>

<?= render('default/public/alert')?>

<!--任务列表-->
<script id="task-my-assign-tmpl" type="text/x-jquery-tmpl">
{{each(index, item) data}}
    <tr data-id="${item.id}">
        <td>#${item.union_id}</td>
        {{if item.type === '1'}}
        <td><span style="font-size:14px;background-color:#e85b72;color:#fff;padding:3px 5px;border-radius:5px">${item.type_name}</span></td>
        {{/if}}
        {{if item.type === '2'}}
        <td><span style="font-size:14px;background-color:#56b8eb;color:#fff;padding:3px;border-radius:5px">${item.type_name}</span></td>
        {{/if}}
        {{if item.type === '3'}}
        <td><span style="font-size:14px;background-color:#a2d148;color:#fff;padding:3px;border-radius:5px">${item.type_name}</span></td>
        {{/if}}
        <td>${item.project}</td>
        <td>${item.title}</td>
        <td>${item.publisher}</td>
        <td>${item.to_user}</td>

        {{if item.status === '1'}}
            <td><span style="font-size:12px;background-color:#e85b72;color:#fff;padding:3px 5px;border-radius:5px">${item.status_name}</span></td>
        {{/if}}
        {{if item.status === '2'}}
            <td><span style="font-size:12px;background-color:#56b8eb;color:#fff;padding:3px 5px;border-radius:5px">${item.status_name}</span></td>
        {{/if}}
        {{if item.status === '3'}}
            <td><span style="font-size:12px;background-color:#a2d148;color:#fff;padding:3px 5px;border-radius:5px">${item.status_name}</span></td>
        {{/if}}

        <td>${item.created_at}</td>
        <td>
            ${item.end_at}
        {{if item.is_past.is_past === 1}}
          <span style="font-size:10px;background-color:#e85b72;color:#fff;padding:2px 4px;border-radius:5px"">已逾期</span>
        {{/if}}
        </td>
        <td>
            <a href="javascript:void(0);" role="review-task">查看</a>
        </td>
    </tr>
{{/each}}
</script>

<?php

echo Asset::css([

]);

echo Asset::js([
    '//cdn.bootcss.com/jquery/3.2.1/jquery.js',
    '//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js',
    'lib/jquery.tmpl.min.js',
    'lib/laydate/laydate.js',
    'public/public.js',
    'public/paginations.js',
    'task/my_assign.js'
]);

?>
