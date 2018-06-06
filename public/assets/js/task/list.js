/**
 * Created by ray on 2017/12/28.
 */

// 全局变量
let global = {
    defaultPage: 1,
};

// 初始化操作
$(function () {

    $('#project_id,#pid,#uid,#status').change(function () {
        getTasks(1);
    });

    $('#task-my-tasks-table').delegate('select[name=project_id]', 'change', function(){

        var select = $(this);

        $.ajax({
            url: '/api/task?id=' + $(this).parents('tr').attr('data-id'),
            type: 'PUT',
            data: {
                project_id: select.val()
            },
            dataType: 'json',
            success: function (res) {
                if (res.status === 'err') {
                    select.css('color', 'red');
                    showAlert(res.msg, 'am-alert-danger')
                    return;
                }

                select.css('color', 'green');
            }
        })

    });

    getProjects();
    getUsers();
    getStatus();
});

// 查看任务点击
$('#task-my-tasks-table').delegate('tr a[role=review-task]', 'click', function () {
    let id = $(this).parents('tr').attr('data-id');
    window.location.href = '/project/details?id=' + id + '&flag=1';
});

// 获取我的任务列表
function getTasks (page) {

    var params = '';
    params = $('#project_id').val() > 0 ? '&project_id=' + $('#project_id').val() : '';
    params += $('#pid').val() > 0 ? '&pid=' + $('#pid').val() : '';
    params += $('#uid').val() > 0 ? '&uid=' + $('#uid').val() : '';
    params += $('#status').val() > 0 ? '&status=' + $('#status').val() : '';

    return new Promise((resolve, reject) => {
            $.ajax({
            url: '/api/task/list?start=' + page + params,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'succ') {
                    let newTasks = res.data;
                    // 处理返回的数据
                    for (let i = 0; i < newTasks.length; i++) {
                        if (newTasks[i].type === '1') newTasks[i].type_name = 'Bug';
                        else if (newTasks[i].type === '2') newTasks[i].type_name = '功能';
                        else if (newTasks[i].type === '3') newTasks[i].type_name = '任务';

                        if (newTasks[i].status === '1') newTasks[i].status_name = '待处理';
                        else if (newTasks[i].status === '2') newTasks[i].status_name = '待测试';
                        else if (newTasks[i].status === '3') newTasks[i].status_name = '已完成';
                        else if (newTasks[i].status === '4') newTasks[i].status_name = '已撤销';

                        newTasks[i].created_date = tools.toTime(newTasks[i].created_at);
                        newTasks[i].end_date = tools.toTime(newTasks[i].end_at);
                    }
                    res.now = Date.parse(new Date()) / 1000;
                    res.projects = _projects;
                    $('#task-my-tasks-table').empty();
                    $('#task-my-tasks-table-tmpl').tmpl(res).appendTo('#task-my-tasks-table');
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-danger')
                }
                resolve(res);
            }
        })
});
}

function getStatus() {
    $.ajax({
        url: '/api/task/status',
        type: 'get',
        dataType: 'json',
        success: function (res) {

            if (res.status == 'err') {
                return;
            }

            for (let i = 0; i < res.data.length; i++) {
                $('#status').append('<option value="'+ i +'"' + (_status == i ? ' selected' : '') + '>' + res.data[i] + '</option>');
            }
        }
    })
}

// 获取user
function getUsers () {
    $.ajax({
        url: '/api/user',
        type: 'get',
        dataType: 'json',
        success: function (res) {

            if (res.status == 'err') {
                return;
            }

            for (let i = 0; i < res.data.length; i++) {
                $('#pid').append('<option value="'+ res.data[i].id +'"' + (_pid == res.data[i].id ? ' selected' : '') + '>'+ res.data[i].full_name +'</option>');
                $('#uid').append('<option value="'+ res.data[i].id +'"' + (_uid == res.data[i].id ? ' selected' : '') + '>'+ res.data[i].full_name +'</option>');
            }
        }
    })
}

function getProjects () {
    $.ajax({
        url: '/api/project',
        type: 'get',
        dataType: 'json',
        success: function (res) {

            if (res.status == 'err') {
                return;
            }
            _projects = res.data;
            for (let i = 0; i < res.data.length; i++) {
                $('#project_id').append('<option value="'+ res.data[i].id +'"' + (_project_id == res.data[i].id ? ' selected' : '') + '>'+ res.data[i].title +'</option>');
            }

            getTasks(global.defaultPage).then((data) => {
                $('#current-page-num').text(data.current_page);
                $('#total-pages-num').text(data.total_page);
                page.currentPage = parseInt(data.current_page);
                page.totalPages = parseInt(data.total_page);
                page.callback = getTasks;
            });
        }
    })
}

