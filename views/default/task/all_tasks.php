<?php
/**
 * Created by PhpStorm.
 * User: sangs
 * Date: 2018/1/11
 * Time: 14:44
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
    #complete-time-icon{
        transition: all .3s ease-in-out;
        transform-origin: 50% 75%;
        transform: rotate(0deg);
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
    <!--筛选条件-->
    <div class="am-g">
        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <button class="am-btn am-round am-btn-sm am-btn-warning" id="status-text">状态</button>
            <div class="am-dropdown" data-am-dropdown>
                <button style="height: 32px" class="am-btn am-round am-btn-sm am-btn-warning am-dropdown-toggle"
                        data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content" id="screen-by-status">
                    <li class="am-active" data-id=""><a href="#">全部</a></li>
                    <li data-id="1"><a href="#">待处理</a></li>
                    <li data-id="2"><a href="#">待测试</a></li>
                    <li data-id="3"><a href="#">已完成</a></li>
                </ul>
            </div>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <button class="am-btn am-round am-btn-sm am-btn-warning" id="type-text">类型</button>
            <div class="am-dropdown" data-am-dropdown>
                <button style="height: 32px" class="am-btn am-round am-btn-sm am-btn-warning am-dropdown-toggle"
                        data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content" id="screen-by-type">
                    <li class="am-active" data-id=""><a href="#">全部</a></li>
                    <li data-id="1"><a href="#">Bug</a></li>
                    <li data-id="2"><a href="#">功能</a></li>
                    <li data-id="3"><a href="#">任务</a></li>
                </ul>
            </div>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <button class="am-btn am-round am-btn-sm am-btn-primary" id="accept-user-text">指派人</button>
            <div class="am-dropdown" data-am-dropdown>
                <button style="height: 32px" class="am-btn am-round am-btn-sm am-btn-primary am-dropdown-toggle"
                        data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content" id="accept-user" style="height: 420px;overflow-y: scroll">
                    <li class="am-active" data-id=""><a href="#">全部</a></li>
                </ul>
            </div>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <button class="am-btn am-round am-btn-sm am-btn-primary" id="publisher-text">发布人</button>
            <div class="am-dropdown" data-am-dropdown>
                <button style="height: 32px" class="am-btn am-round am-btn-sm am-btn-primary am-dropdown-toggle"
                        data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content" id="publisher" style="height: 420px;overflow-y: scroll">
                    <li class="am-active" data-id=""><a href="#">全部</a></li>
                </ul>
            </div>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <input id="end-at" style="height: 33px;width: 165px;color: #888;" type="text"
                   class="am-form-field am-round" placeholder="选择结束时间"/>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <input id="start-at" style="height: 33px;width: 165px;color: #888;" type="text"
                   class="am-form-field am-round" placeholder="选择开始时间"/>
        </div>

        <div class="am-topbar-right">
            <div id="clear-all-btn" class="am-btn am-btn-danger am-topbar-btn am-round am-btn-sm">清空</div>
        </div>
    </div>
    <ol class="am-breadcrumb">
        <li><a href="/project">项目</a></li>
        <li><a href="#" id="task-all-tasks">全部任务</a></li>
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
            <th style="position: relative">提交时间</th>
            <th style="position: relative">完成时间
                <i id="complete-time-icon" class="am-icon-sort-desc"
                   style="margin-left: 10px;position:absolute;top: 9px;cursor: pointer"></i>
            </th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="task-all-tasks-table">

        </tbody>
    </table>
    <?= render('default/public/pagination')?>
</div>

<?= render('default/public/alert')?>

<!--任务列表-->
<script id="task-all-tasks-table-tmpl" type="text/x-jquery-tmpl">
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
    'task/all_tasks.js'
]);

?>

