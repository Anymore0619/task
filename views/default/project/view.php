<?php
/**
 * 项目详情
 *
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/12/11
 * Time: 13:59
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
                    <li data-id="4"><a href="#">已撤销</a></li>
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
                    <?php foreach($users as $user){ ?>
                        <li data-id="<?= $user['id']?>"><a href="#"><?= $user['username']?></a></li>
                    <?php }?>
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
                    <?php foreach($users as $user){ ?>
                        <li data-id="<?= $user['id']?>"><a href="#"><?= $user['username']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <input id="complete-time" style="height: 33px;width: 165px;color: #888;" type="text"
                   class="am-form-field am-round" placeholder="选择结束时间"/>
        </div>

        <div class="am-btn-group am-topbar-right" style="margin-top: 8px">
            <input id="created-time" style="height: 33px;width: 165px;color: #888;" type="text"
                   class="am-form-field am-round" placeholder="选择开始时间"/>
        </div>

        <div class="am-topbar-right">
            <div id="clear-all-btn" class="am-btn am-btn-danger am-topbar-btn am-round am-btn-sm">清空</div>
        </div>

    </div>
    <ol class="am-breadcrumb">
        <li><a href="/task/project">项目</a></li>
        <li><a href="#" id="task-pro-name"></a></li>
        <li><a href="#">任务列表</a></li>
    </ol>
    <table class="am-table am-table-hover">
        <thead>
        <tr>
            <th>任务单号</th>
            <th>任务类型</th>
            <th>标题</th>
            <th>发布人</th>
            <th>指派人</th>
            <th>当前状态</th>
            <th>提交时间</th>
            <th style="position: relative">完成时间
                <i id="complete-time-icon" class="am-icon-sort-desc"
                   style="margin-left: 10px;position:absolute;top: 9px;cursor: pointer"></i>
            </th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody id="task-project-table">
            <?php if(isset($data)){?>
<!--                --><?php //foreach ($data as $item){ ?>
<!--                    <tr data-id="--><?//= $item['id']?><!--">-->
<!--                        <td>#--><?//= $item['union_id']?><!--</td>-->
<!--                        <td>--><?//= $item['status']?><!--</td>-->
<!--                        <td>--><?//= $item['created_at']?><!--</td>-->
<!--                        --><?php //if(false){?>
<!--                            <td>-->
<!--                                --><?//= $item['status']?>
<!--                                <span style="font-size:10px;background-color:#e85b72;color:#fff;padding:2px 4px;border-radius:5px"">已逾期</span>-->
<!--                            </td>-->
<!--                        --><?php //}?>
<!--                        <td>-->
<!--                            <a href="javascript:void(0);" role="review-task">查看</a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                --><?php //}?>
            <?php }?>

        </tbody>
    </table>
    <?= render('default/public/pagination')?>
</div>

<?= render('default/public/alert')?>

<script>
    var _author_id = <?= \Auth::check() ? \Auth::get_user()->id : 0 ?>;
</script>


<!--添加问题模态框-->
<div class="am-modal am-modal-prompt" tabindex="-1" id="task-add-issue-modal">
    <div class="am-modal-dialog" style="width: 800px;">
        <div class="am-modal-hd">创建任务</div>
        <div class="am-modal-bd">
            <form role="form" id="new-task-form" class="am-form" action="" onsubmit="return false">
                <select name="publisher_id" style="border-radius: 5px;margin-top: 10px" class="am-modal-prompt-input" id="publish-name">
                    <option value="" selected disabled>选择发布人</option>
                    <?php foreach($users as $user){ var_dump($user)?>
                        <option value="<?= $user['id']?>"><?= $user['username']?></option>
                    <?php }?>
                </select>
                <select name="user_id" style="border-radius: 5px;margin-top: 10px" class="am-modal-prompt-input" id="to-user-name">
                    <option value="" selected disabled>选择指派人</option>
                    <?php foreach($users as $user){ var_dump($user)?>
                        <option value="<?= $user['id']?>"><?= $user['username']?></option>
                    <?php }?>
                </select>
                <select name="type" style="border-radius: 5px;margin-top: 10px" class="am-modal-prompt-input" id="">
                    <option value="" selected disabled>选择任务类型</option>
                    <option value="1">Bug</option>
                    <option value="2">功能</option>
                    <option value="3">任务</option>
                </select>
                <input name="title" style="border-radius: 5px;margin-top: 10px" type="text" class="am-modal-prompt-input" placeholder="问题/任务标题">
                <div id="task-describe-editor" style="margin-top: 10px;text-align: left;">

                </div>
                <textarea id="task-describe" name="content" rows="4" style="border-radius: 5px;margin-top: 10px;display: none;"
                          type="text" class="am-modal-prompt-input" placeholder="问题/任务描述"></textarea>
                <input id="end-at" name="end_at" style="border-radius: 5px;margin-top: 10px" type="text" class="am-form-field" placeholder="完成时间"/>
            </form>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span id="submit-new-task" class="am-modal-btn" data-am-modal-confirm>提交</span>
        </div>
    </div>
</div>

<?php

echo Asset::css([

]);

echo Asset::js([
    '//cdn.bootcss.com/jquery/3.2.1/jquery.js',
    '//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js',
    'lib/wangEditor.min.js',
    'lib/laydate/laydate.js',
    'public/public.js',
    'public/paginations.js',
    'project/view.js'
]);

?>
