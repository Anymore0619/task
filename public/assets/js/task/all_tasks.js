/**
 * Created By SangShaoFeng
 * Date 2018/1/11
 * 全部任务
 */



// 全局变量对象
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

// 分页对象
let p = {

    currentPage: 1,                        // 当前页
    totalPages: '',                        // 所有页

};

// 初始化
$(function () {

    // 初始化laydate
    laydate.render({
        elem: '#start-at',
        type: 'datetime',
        done: function (value, date, endDate) {
            g.startAt = isNaN(tools.toTimestamp(value)) === true ? 0 : tools.toTimestamp(value);
            if ($('#end-at').val() === '') {
                return false;
            } else {
                loadData(1);
            }
        }
    });

    laydate.render({
        elem: '#end-at',
        type: 'datetime',
        done: function (value, date, endDate) {
            g.endAt = isNaN(tools.toTimestamp(value)) === true ? 0 : tools.toTimestamp(value);
            if ($('#start-at').val() === '') {
                return false;
            } else {
                loadData(1);
            }
        }
    });

    getUsers();

    loadData(1);

});

// 分页操作
$(function () {

    // "首页"点击
    $('#task-first-page').click(function () {
        p.currentPage = 1;
        loadData(p.currentPage)
    });

    // "上一页"点击
    $('#task-prev-page').click(function () {
        if (p.currentPage > 1) {
            p.currentPage --;
            loadData(p.currentPage)
        } else return false;
    });

    // "下一页"点击
    $('#task-next-page').click(function () {
        if (p.currentPage < p.totalPages) {
            p.currentPage ++;
            loadData(p.currentPage)
        } else return false;
    });


    // "末页"点击
    $('#task-last-page').click(function () {
        p.currentPage = p.totalPages;
        loadData(p.currentPage);
    });

});

// 事件监听
$(function () {

    // 查看任务点击
    $('#task-all-tasks-table').delegate('tr a[role=review-task]', 'click', function () {
        let id = $(this).parents('tr').attr('data-id');
        window.open('/project/details?id=' + id + '&flag=3');
    });

    // 完成时间升降序icon点击
    let rotate = 0;
    $('#complete-time-icon').click(function () {
        rotate = (rotate + 180) % 360;
        $(this).css('transform', 'rotate(' + rotate + 'deg)');

        if (rotate === 180) g.endOrder = 1;
        else g.endOrder = 0;

        loadData(1);
    });

    // "按类型"点击
    $('#screen-by-type').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.type = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#type-text').text('类型');
        else $('#type-text').text(text);

        loadData(1);
    });

    // "按状态"点击
    $('#screen-by-status').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.status = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#status-text').text('状态');
        else $('#status-text').text(text);

        loadData(1);
    });

    // "指派人"点击
    $('#accept-user').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.accepter = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#accept-user-text').text('指派人');
        else $('#accept-user-text').text(text);

        loadData(1);
    });

    // "发布人"点击
    $('#publisher').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.publisher = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#publisher-text').text('发布人');
        else $('#publisher-text').text(text);

        loadData(1);
    });

    // "清空"点击
    $('#clear-all-btn').click(function () {
        resetConditions();
        loadData(1);
    });

});

// 获取全部任务
function loadData (page) {
    return new Promise((resolve, reject) => {
        let url = '/api/task/divide?id=';
        url += '&key=' + g.status;
        url += '&type=' + g.type;
        url += '&user=' + g.accepter;
        url += '&publisher=' + g.publisher;
        url += '&start_at=' + g.startAt;
        url += '&end_at=' + g.endAt;
        url += '&end_order=' + g.endOrder;
        url += '&created_order=' + g.createdOrder;

        $.ajax({
            url: url + '&start=' + page,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status === 'succ') {
                    p.currentPage = res.current_page;
                    p.totalPages = res.total_page;
                    renderDom(res);
                    resolve(res);
                } else if (res.status === 'err') {
                    showAlert(res.msg, 'am-alert-danger');
                }
            }
        })
    })
}

// 获取users
function getUsers () {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/user',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                renderUsersList(res.data);
                resolve(res);
            }
        })
    })
}

// 渲染用户列表
function renderUsersList (data) {
    for (let i = 0; i < data.length; i++) {
        let li = '<li data-id="'+ data[i].id +'"><a href="#">'+ data[i].full_name +'</a></li>';
        $('#accept-user').append(li);
        $('#publisher').append(li);
    }
}

// 重置筛选条件
function resetConditions () {
    $('#type-text').text('类型');
    $('#status-text').text('状态');
    $('#accept-user-text').text('指派人');
    $('#publisher-text').text('发布人');
    $('#start-at').val('');
    $('#end-at').val('');

    $('#screen-by-status').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#screen-by-type').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#accept-user').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');
    $('#publisher').find('li:eq(0)').addClass('am-active').siblings('li').removeClass('am-active');

    g.status = ''; g.type = ''; g.publisher = ''; g.accepter = '';
    g.endAt = ''; g.startAt = '';
}

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
    $('#task-all-tasks-table').empty();
    $('#task-all-tasks-table-tmpl').tmpl(data).appendTo('#task-all-tasks-table');
}


