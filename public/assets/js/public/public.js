// 工具函数
let tools = {
    // 时间戳转时间
    toTime: function (d) {
        let date = new Date(d * 1000);  //如果date为10位不需要乘1000
        let Y = date.getFullYear() + '-';
        let M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        let D = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate()) + ' ';
        let h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
        let m = (date.getMinutes() <10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
        let s = (date.getSeconds() <10 ? '0' + date.getSeconds() : date.getSeconds());
        return Y + M + D + h + m + s;
    },
    // 时间转时间戳
    toTimestamp: function (d) {
        let date = new Date();
        date.setFullYear(d.substring(0, 4));
        date.setMonth(d.substring(5, 7)-1);
        date.setDate(d.substring(8, 10));
        date.setHours(d.substring(11, 13));
        date.setMinutes(d.substring(14, 16));
        date.setSeconds(d.substring(17, 19));
        return Date.parse(date) / 1000;
    },
    //获取地址栏参数,可以是中文参数
    getUrlParam: function (key) {
        let url = window.location.search;
        let reg = new RegExp("(^|&)" + key + "=([^&]*)(&|$)");
        let result = url.substr(1).match(reg);
        return result ? decodeURIComponent(result[2]) : null;
    },
};

// 显示提示框alert
function showAlert (msg, color) {
    $('#task-alert').fadeIn(200);
    $('#task-alert').removeClass('am-alert-danger am-alert-success').addClass(color);
    $('#task-alert p').text(msg);
    setTimeout(function () {
        $('#task-alert').fadeOut(500);
    }, 3000)
}