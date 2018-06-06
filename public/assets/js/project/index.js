
// 初始化操作
$(function () {

});

// 创建项目按钮点击显示模态框
$('#task-add-project-btn').click(function () {
    $('#task-add-project-modal').modal();
});

// 提交新创建项目点击
$('#submit-new-project').click(function () {
    let params = $('#task-pro-form').serialize();
    submitNewProject(params);
});


// 提交新创建的项目 => post
function submitNewProject (data) {
    $.ajax({
        url: '/api/project',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (res) {
            console.log(res);
            if (res.status === 'succ') {
                $('#task-pro-form input').val('');
                showAlert('发布成功！', 'am-alert-success');
                getProjects();
            } else if (res.status === 'err') {
                showAlert(res.msg, 'am-alert-danger')
            }
        }
    })
}