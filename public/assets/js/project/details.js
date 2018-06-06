/**
 * Created By SangShaofeng
 * Date 2017/12/18
 * 任务详情页
 */


// 全局变量
let global = {
    flag: tools.getUrlParam('flag'),       // flag=1回到我的任务，flag=2回到我的指派
    id: tools.getUrlParam('id'),           // 任务id
    p_id: tools.getUrlParam('project_id')  // 项目id
};

// 初始化操作
$(function () {
    getTaskDetails(global.id).then((res) => {
        getUsers(res).then((data) => {
            insertData(data);
        })
    });
});

// 跳回任务页面
$('#back-to-task').click(function () {
    if (global.flag && global.flag === '1') {
        window.location.href = '/project/my_tasks';
    } else if (global.flag && global.flag === '2') {
        window.location.href = '/project/my_assign';
    } else if (global.flag && global.flag === '3') {
        window.location.href = '/project/all_tasks';
    } else {
        window.location.href = '/project/view?id=' + global.p_id;
    }
});

// 监听修改状态下拉框
$('#task-status').change(function () {
    $('#task-comment-modal').modal();
});

// 监听"指派人下拉框"
$('#task-to-user').change(function () {
    $('#task-comment-modal').modal();
});

// 提交评论按钮点击
$('#submit-comment-btn').click(function () {
    let params = {};
    params.status = $('#task-status').val();
    params.content = $('#pro-task-comment').val();
    params.parent_id = $('#task-to-user').val();
    editTaskStatus(global.id, params).then(() => {
        getTaskDetails(global.id).then((res) => {
            getUsers(res).then((data) => {
                insertData(data);
            })
        });
    });
});

// 取消提交修改按钮点击
$('#cancel-submit-btn').click(function () {
    getTaskDetails(global.id).then((res) => {
        getUsers(res).then((data) => {
            insertData(data);
        })
    });
});

// 写入数据
function insertData (res) {
    if (res.data.item.type === '1') res.data.item.type_name = 'Bug';
    else if (res.data.item.type === '2') res.data.item.type_name = '功能';
    else if (res.data.item.type === '3') res.data.item.type_name = '任务';
    if (res.status === 'succ') {
        if (res.data.item.content === '') res.data.item.content = '未填写描述';
        let logData = res.data.item.logs;
        for (let i = 0; i < logData.length; i++) {
            logData[i].created_at = tools.toTime(logData[i].created_at);
            if (logData[i].status === '1') logData[i].status_name = '待处理';
            else if (logData[i].status === '2') logData[i].status_name = '待测试';
            else if (logData[i].status === '3') logData[i].status_name = '已完成';
            else if (logData[i].status === '4') logData[i].status_name = '已撤销';
            if (logData[i].content === '') logData[i].content = '没有添加任何评论~'
        }
        res.data.item.created_at = tools.toTime(res.data.item.created_at);
        res.data.item.end_at = tools.toTime(res.data.item.end_at);
        $('#task-no').text('任务单号 # ' + res.data.item.union_id);
        $('#task-title').text(res.data.item.title);
        $('#task-desc').html(res.data.item.content);
        $('#task-type').text(res.data.item.type_name);
        $('#task-status').val(res.data.item.status);
        $('#task-publisher').text(res.data.full_name.publisher);
        $('#task-to-user').val(res.data.item.user_id);
        $('#task-created').text(res.data.item.created_at);
        $('#task-end').text(res.data.item.end_at);
        $('#task-comment').empty();
        $('#task-comment-tmpl').tmpl(res.data.item).appendTo('#task-comment');
    }
}

// 获取指定id任务详情
function getTaskDetails (task_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/task/item?id=' + task_id,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                resolve(res);
            }
        })
    })
}

// 修改任务状态
function editTaskStatus (task_id, params) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/task?id=' + task_id,
            type: 'put',
            data: params,
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status === 'succ') {
                    showAlert('操作成功！', 'am-alert-success')
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-danger')
                }
                resolve();
            }
        })
    })
}

// 获取user
function getUsers (data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/user',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                for (let i = 0; i < res.data.length; i++) {
                    $('#task-to-user').append('<option style="color: #000;" value="'+ res.data[i].id +'">'+ res.data[i].full_name +'</option>');
                }
                resolve(data);
            }
        })
    })
}