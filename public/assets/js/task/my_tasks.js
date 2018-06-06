/**
 * Created By SangShaofeng
 * Date 2017/12/26
 * title 我的任务
 */


// 全局变量
let global = {

};

// 分类检索对象
let g = {

    status: '',          // 任务状态

};

// 分页对象
let p = {

    currentPage: 1,                        // 当前页
    totalPages: '',                        // 所有页

};

// 初始化操作
$(function () {

    loadData(1);

});

// 事件监听
$(function () {

    // 查看任务点击
    $('#task-my-tasks-table').delegate('tr a[role=review-task]', 'click', function () {
        let id = $(this).parents('tr').attr('data-id');
        window.open('/project/details?id=' + id + '&flag=1');
    });

    // "按状态分类"点击
    $('#screen-by-status').delegate('li', 'click', function () {
        $(this).addClass('am-active').siblings('li').removeClass('am-active');
        g.status = $(this).attr('data-id');

        let text = $(this).find('a').text();
        if (text === '全部') $('#status-text').text('状态');
        else $('#status-text').text(text);

        loadData(1);
    });

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

// 获取我的任务列表
function loadData (page) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/task/tasks?key=' + g.status + '&start=' + page,
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
                    showAlert(res.msg, 'am-alert-danger')
                }
            }
        })
    });
}

function renderDom (res) {
    $('#current-page-num').text(res.current_page);
    $('#total-pages-num').text(res.total_page);
    let newTasks = res.data;
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
    $('#task-my-tasks-table').empty();
    $('#task-my-tasks-table-tmpl').tmpl(res).appendTo('#task-my-tasks-table');
}

