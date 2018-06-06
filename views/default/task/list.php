<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/12/28
 * Time: 15:55
 */
?>

<style>
    .task-wrapper{
        width: 1300px;
        margin: 50px auto;
    }
</style>

<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="#">送车中国任务管理系统</a>
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
        <li><a href="#" id="task-my-tasks">我的任务</a></li>
        <li><a href="#">任务列表</a></li>
    </ol>

    <div class="am-g">
        <div class="am-u-md-2">
            <select id="project_id" class="am-modal-prompt-input">
                <option value="0">请选择项目</option>
            </select>
        </div>
        <div class="am-u-md-2">
            <select id="uid" class="am-modal-prompt-input">
                <option value="0">请选择指派人</option>
            </select>
        </div>
        <div class="am-u-md-2">
            <select id="pid" class="am-modal-prompt-input">
                <option value="0">请选择发布人</option>
            </select>
        </div>
        <div class="am-u-md-2">
            <select id="status" class="am-modal-prompt-input">
            </select>
        </div>
        <div class="am-u-md-4">
        </div>
    </div>

    <table class="am-table">
        <thead>
        <tr>
            <th>任务</th>
            <th>所属项目</th>
            <th>标题</th>
            <th>发布/指派人</th>
            <th>创建/完成时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="task-my-tasks-table" class="am-form">

        </tbody>
    </table>
    <?= render('default/public/pagination')?>
</div>

<?= render('default/public/alert')?>

<!--任务列表-->
<script id="task-my-tasks-table-tmpl" type="text/x-jquery-tmpl">
{{each(index, item) data}}
    <tr data-id="${item.id}"{{if item.end_at < now}} style="color: red;"{{/if}}>
        <td>
            <p>
                #${item.union_id}<br>
                {{if item.type === '1'}}
                <span style="font-size:14px;background-color:#e85b72;color:#fff;padding:3px 5px;border-radius:5px">${item.type_name}</span>
                {{/if}}
                {{if item.type === '2'}}
                <span style="font-size:14px;background-color:#56b8eb;color:#fff;padding:3px;border-radius:5px">${item.type_name}</span>
                {{/if}}
                {{if item.type === '3'}}
                <span style="font-size:14px;background-color:#a2d148;color:#fff;padding:3px;border-radius:5px">${item.type_name}</span>
                {{/if}}
            </p>
        </td>
        <td>
            <select name="project_id" class="am-modal-prompt-input">
            {{each(pIndex, project) projects}}
                <option value="${project.id}"{{if project.id == item.project_id}} selected{{/if}}>${project.title}</option>
            {{/each}}
            </select>
        </td>
        <td>${item.title}</td>
        <td>${item.publisher}<br>${item.to_user}</td>
        <td>${item.created_date}<br>${item.end_date}</td>
        <td>${item.status_name}</td>
        <td>
            <a href="javascript:void(0);" role="review-task">查看</a>
        </td>
    </tr>
{{/each}}
</script>
<script>
    var _pid = <?= \Input::get('pid', 0); ?>;
    var _uid = <?= \Input::get('uid', 0); ?>;
    var _project_id = <?= \Input::get('project_id', 0); ?>;
    var _status = <?= \Input::get('status', 0); ?>;
    var _projects = [];
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
    'task/list.js'
]);

?>


