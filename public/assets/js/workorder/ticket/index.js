/**
 * Created By SangShaofeng
 * Date 2017/12/13
 */

// 全局变量对象
let global = {

};

// 初始化操作
$(function () {

    reload();

});

// 显示创建工单模态框
$('#task-add-ticket-btn').click(function () {
   $('#task-add-ticket-modal').modal();
});

// 提交工单按钮点击
$('#submit-ticket-btn').click(function () {
    let params = $('#task-ticket-form').serialize();
    submitNewTicket(params).then((data) => {
        reload();
    });
});

// 查看工单操作
$('#task-ticket-table').delegate('a[role=review-ticket]', 'click', function () {
    let tr = $(this).parents('tr');
    let id = tr.attr('data-id');
    window.location.href = '/workorder/ticket/view/' + id;
});

// 撤销工单操作
$('#task-ticket-table').delegate('a[role=revoke-ticket]', 'click', function () {
    let tr = $(this).parents('tr');
    let id = tr.attr('data-id');
    revokeTicket(id).then(() => {
        reload();
    });
});

// 获取所有工单 => get
function getTickets (page) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/ticket?start=' + page,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'err') return false;
                else if (res.status === 'succ') {
                    renderTable(res);
                    resolve(res);
                }
            }
        })
    })
}

// 状态变更时重新加载数据
function reload () {
    getTickets(1).then((data) => {
        pagination.init({
            currentPage: parseInt(data.current_page),
            totalPages: parseInt(data.total_page),
            onClickJump: function () {
                getTickets(this.currentPage);
            }
        });
        pagination.onClickEvent();
    })
}

// 渲染列表
function renderTable (res) {
    for (let i = 0; i < res.data.length; i++) {
        res.data[i].created_at = tools.toTime(res.data[i].created_at);
        res.data[i].end_at = tools.toTime(res.data[i].end_at);
        if (res.data[i].status === '1') {
            res.data[i].status_name = '待处理'
        } else if (res.data[i].status === '2') {
            res.data[i].status_name = '处理中'
        } else if (res.data[i].status === '3') {
            res.data[i].status_name = '已完成'
        } else if (res.data[i].status === '4') {
            res.data[i].status_name = '已撤销'
        }
    }
    $('#task-add-ticket-modal').find('input[name=name]').val(res.full_name);
    $('#task-ticket-table').empty();
    $('#task-ticket-table-tmpl').tmpl(res).appendTo('#task-ticket-table');
}

// 撤销工单
function revokeTicket (id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/ticket/cancel?id=' + id,
            type: 'post',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status === 'succ') {
                    showAlert('撤销成功！', 'am-alert-success');
                    resolve(res);
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-warning');
                }
            }
        })
    })
}

// 创建工单提交方法 => post
function submitNewTicket (data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/ticket',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status === 'succ') {
                    showAlert('发布成功！', 'am-alert-success');
                    resolve(res);
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-warning');
                }
            }
        })
    })
}