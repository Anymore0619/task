/**
 * 分页器
 * Created By SangShaofeng
 * Date 2017/12/14
 */


let pagination = (function () {

    function P () {

        this.params = {
            currentPage: 0,
            totalPages: 0,
            onClickJump: function (params) {
                return params;
            }
        }

    }

    P.prototype = {

        // 初始化
        init: function () {
            let t = this;
            t.newParams = arguments[0];
            t.extend(t.params, t.newParams);

            $('#current-page-num').text(t.params.currentPage);
            $('#total-pages-num').text(t.params.totalPages);
        },

        // "首页"点击
        onClickFirst: function () {
            let t = this;
            $('#task-first-page').click(function () {
                t.params.currentPage = 1;
                t.params.onClickJump();
                $('#current-page-num').text(t.params.currentPage);
                $('#total-pages-num').text(t.params.totalPages);
            });
        },

        // "上一页"点击
        onClickPrev: function () {
            let t = this;
            $('#task-prev-page').click(function () {
                if (t.params.currentPage > 1) {
                    t.params.currentPage --;
                    t.params.onClickJump();
                    $('#current-page-num').text(t.params.currentPage);
                    $('#total-pages-num').text(t.params.totalPages);
                } else return false;
            });
        },

        // "下一页"点击
        onClickNext: function () {
            let t = this;
            $('#task-next-page').click(function () {
                if (t.params.currentPage < t.params.totalPages) {
                    t.params.currentPage ++;
                    t.params.onClickJump();
                    $('#current-page-num').text(t.params.currentPage);
                    $('#total-pages-num').text(t.params.totalPages);
                } else return false;
            });
        },

        // "末页"点击
        onClickLast: function () {
            let t = this;
            $('#task-last-page').click(function () {
                t.params.currentPage = t.params.totalPages;
                t.params.onClickJump();
                $('#current-page-num').text(t.params.currentPage);
                $('#total-pages-num').text(t.params.totalPages);
            });
        },

        onClickEvent: function () {
            this.onClickFirst();
            this.onClickPrev();
            this.onClickNext();
            this.onClickLast();
        },

        // 更新参数列表
        extend: function (Old, New) {
            for (let i in New) {
                Old[i] = New[i];
            }
        }
    };

    return new P();

})(window, document);

