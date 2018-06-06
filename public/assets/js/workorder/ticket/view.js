/**
 * Created By SangShaofeng
 * Date 2017/12/13
 */

// 修改参数列表
let p = {
    status: '',
    content: '',
    endAt: '',
};

// 初始化操作
$(function () {

    getTicketDetails(global.id);

    laydate.render({
        elem: '#edit-end-time',
        type: 'datetime',
        done: function (value, date, endDate) {
            $('#task-ticket-comment-modal').modal();
            p.status = '';
            p.endAt = tools.toTimestamp(value);
        }
    });

});

// 监听修改状态下拉框
$('#task-ticket-status').on('change', function () {
    $('#task-ticket-comment-modal').modal();
    p.status = $('#task-ticket-status').val();
    p.content = $('#ticket-comment').val();
    p.endAt = '';
});

// 提交评论按钮点击
$('#submit-comment-btn').click(function () {
    p.content = $('#ticket-comment').val();
    alterTicketStatus(p, global.id);
});

// 取消提交修改按钮点击
$('#cancel-submit-btn').click(function () {
    getTicketDetails(global.id)
});

// // 生成参数对象
// function objParams () {
//
//     let params = {};
//     params.status = $('#task-ticket-status').val();
//     params.content = $('#ticket-comment').val();
//     params.endAt = tools.toTimestamp($('#edit-end-time').val());
//     return params;
//
// }

// 获取指定id订单详情
function getTicketDetails (id) {
    $.ajax({
        url: '/api/ticket/item?id=' + id,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            console.log(res);
            if (res.status === 'succ') {
                for (let i = 0; i < res.data.logs.length; i++) {
                    res.data.logs[i].update_at = tools.toTime(res.data.logs[i].update_at);
                }
                renderData(res);
            }
        }
    })
}

// 渲染数据到dom
function renderData (res) {
    let logData = res.data.logs;
    for (let i = 0; i < logData.length; i++) {
        logData[i].created_at = tools.toTime(logData[i].created_at);
        if (logData[i].status === '1') logData[i].status_name = '待处理';
        else if (logData[i].status === '2') logData[i].status_name = '处理中';
        else if (logData[i].status === '3') logData[i].status_name = '已完成';
        else if (logData[i].status === '4') logData[i].status_name = '已撤销';
        if (logData[i].content === '') logData[i].content = '没有添加任何评论~'
    }
    res.data.created_at = tools.toTime(res.data.created_at);
    res.data.end_at = tools.toTime(res.data.end_at);
    $('#task-ticket-title').text(res.data.title);
    $('#task-ticket-desc').text(res.data.content);
    $('#task-ticket-name').text(res.data.name);
    $('#task-ticket-created').text(res.data.created_at);
    $('#edit-end-time').val(res.data.end_at);
    $('#task-ticket-status').val(res.data.status);
    $('#task-ticket-comment').empty();
    $('#task-ticket-comment-tmpl').tmpl(res.data).appendTo('#task-ticket-comment');
}

// 修改订单状态 O => 参数对象  id => 订单id
function alterTicketStatus (O, id) {
    console.log(O);
    $.ajax({
        url: '/api/ticket?id=' + id,
        type: 'put',
        data: {
            status: O.status,
            content: O.content,
            end_at: O.endAt
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'succ') {
                showAlert('操作成功！', 'am-alert-success');
                getTicketDetails(id);
            } else if (res.status === 'err') {
                showAlert(res.msg, 'am-alert-warning');
            }
        }
    })
}
