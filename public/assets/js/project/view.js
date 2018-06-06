// 全局变量对象
let global = {

    id: tools.getUrlParam('id'),           // 项目id
    myId: '',                              // 当前登录用户id

};

// 分页对象
let p = {

    currentPage: 1,                        // 当前页
    totalPages: '',                        // 所有页

};

// 查找关键字对象
let g = {

    status: '',                 // 任务状态id
    type: '',                   // 任务类型id
    publisher: '',              // 发布人id
    accepter: '',               // 指派人id
    startAt: '',                // 开始时间
    endAt: '',                  // 结束时间
    endOrder: 0,                // 按结束时间排序
    createdOrder: 0,            // 按开始时间排序

};

// 初始化操作
$(function () {

    $('#task-describe').val('');

    // 初始化富文本编辑器
    let E = window.wangEditor;
    let editor = new E('#task-describe-editor');
    let $text1 = $('#task-describe');
    editor.customConfig.onchange = function (html) {
        $text1.val(html)
    };
    editor.create();
    $text1.val(editor.txt.html());

    laydate.render({
        elem: '#end-at',
        type: 'datetime'
    });

    laydate.render({
        elem: '#created-time',
        type: 'datetime',
        done: function (value, date, endDate) {
            g.startAt = isNaN(tools.toTimestamp(value)) === true ? 0 : tools.toTimestamp(value);
            if ($('#complete-time').val() === '') {
                return false;
            } else {

            }
        }
    });

    laydate.render({
        elem: '#complete-time',
        type: 'datetime',
        done: function (value, date, endDate) {
            g.endAt = isNaN(tools.toTimestamp(value)) === true ? 0 : tools.toTimestamp(value);
            if ($('#created-time').val() === '') {
                return false;
            } else {

            }
        }
    });


});

// 事件监听
$(function () {

    // 新建任务按钮点击
    $('#task-add-task-btn').click(function () {
        $('#task-add-issue-modal').modal();
        $('#publish-name').val(global.myId);
        $('#to-user-name').val(global.myId);
    });

    // 提交发布任务按钮点击
    $('#submit-new-task').click(function () {
        let params = $('#new-task-form').serialize();
        publishTask(global.id, params).then(() => {

        })
    });

    // 查看任务点击
    $('#task-project-table').delegate('tr a[role=review-task]', 'click', function () {
        let id = $(this).parents('tr').attr('data-id');
        window.open('/project/details?id=' + id + '&project_id=' + global.id)
    });

    // 完成时间升降序icon点击
    let rotate = 0;
    $('#complete-time-icon').click(function () {
        rotate = (rotate + 180) % 360;
        $(this).css('transform', 'rotate(' + rotate + 'deg)');

        if (rotate === 180) g.endOrder = 1;
        else g.endOrder = 0;


    });

    // "按类型"点击
    $('#screen-by-type').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.type = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#type-text').text('类型');
        else $('#type-text').text(text);


    });

    // "按状态"点击
    $('#screen-by-status').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.status = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#status-text').text('状态');
        else $('#status-text').text(text);


    });

    // "指派人"点击
    $('#accept-user').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.accepter = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#accept-user-text').text('指派人');
        else $('#accept-user-text').text(text);


    });

    // "发布人"点击
    $('#publisher').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.publisher = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#publisher-text').text('发布人');
        else $('#publisher-text').text(text);


    });

    // "清空"点击
    $('#clear-all-btn').click(function () {
        resetConditions();

    })

});

// 分页操作
$(function () {

    // "首页"点击
    $('#task-first-page').click(function () {
        p.currentPage = 1;

    });

    // "上一页"点击
    $('#task-prev-page').click(function () {
        if (p.currentPage > 1) {
            p.currentPage --;

        } else return false;
    });

    // "下一页"点击
    $('#task-next-page').click(function () {
        if (p.currentPage < p.totalPages) {
            p.currentPage ++;

        } else return false;
    });


    // "末页"点击
    $('#task-last-page').click(function () {
        p.currentPage = p.totalPages;
    });

});


// 渲染dom
function renderDom (data) {
    $('#current-page-num').text(data.current_page);
    $('#total-pages-num').text(data.total_page);
    let newTasks = data.data;
    for (let i = 0; i < newTasks.length; i++) {
        if (newTasks[i].type === '1') newTasks[i].type_name = 'Bug';
        else if (newTasks[i].type === '2') newTasks[i].type_name = '功能';
        else if (newTasks[i].type === '3') newTasks[i].type_name = '任务';

        if (newTasks[i].status === '1') newTasks[i].status_name = '待处理';
        else if (newTasks[i].status === '2') newTasks[i].status_name = '待测试';
        else if (newTasks[i].status === '3') newTasks[i].status_name = '已完成';
        else if (newTasks[i].status === '4') newTasks[i].status_name = '已撤销';

        newTasks[i].created_at = tools.toTime(newTasks[i].created_at);
        newTasks[i].end_at = tools.toTime(newTasks[i].end_at);
    }
    $('#task-pro-name').text(data.project_name);
    $('#task-project-table').empty();
    $('#task-project-table-tmpl').tmpl(data).appendTo('#task-project-table');
}

// 重置筛选条件
function resetConditions () {
    $('#type-text').text('类型');
    $('#status-text').text('状态');
    $('#accept-user-text').text('指派人');
    $('#publisher-text').text('发布人');
    $('#complete-time').val('');
    $('#created-time').val('');

    $('#screen-by-status').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#screen-by-type').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#accept-user').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#publisher').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');

    g.status = ''; g.type = ''; g.publisher = ''; g.accepter = '';
    g.endAt = ''; g.startAt = '';
}

// 新建发布任务
function publishTask (id, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/task?id=' + id,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status === 'succ') {
                    showAlert('发布成功！', 'am-alert-success');
                    $('#new-task-form').find('select, textarea').val('');
                    $('input[name=title]').val('');
                    resolve();
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-danger')
                }
            }
        })
    })
}


