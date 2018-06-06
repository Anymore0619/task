/**
 * Created By SangShaofeng
 * Date 2017/12/12
 */

// 登录按钮点击
$('#task-login-btn').click(function () {
    let params = new Object;
    params.username = $('#task-username').val();
    params.password = $('#task-password').val();
    checkLogin(params);
});

// 回车登录
$('#task-username, #task-password').keydown(function (e) {
    let params = new Object;
    params.username = $('#task-username').val();
    params.password = $('#task-password').val();
    if (e.keyCode === 13) {
        checkLogin(params);
    }
});

// 登录校验
function checkLogin (params) {
    $.ajax({
        url: '/api/auth/login',
        type: 'post',
        data: {
            username: params.username,
            password: window.btoa(params.password)
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'err') {
                showAlert(res.msg, 'am-alert-danger');
            } else if (res.status === 'succ') {
                showAlert('登陆成功！', 'am-alert-success');
                setTimeout(function () {
                    window.location.href = '/task/home';
                }, 1500);
            }
        }
    })
}