<?php
/**
 * 分页器
 * Created By SangShaofeng
 * Date 2017/12/13
 */
?>

<div id="pagination">
    <div style="float: left;margin-top: 40px">
        <p>当前第<span id="current-page-num" style="font-size: 14px;
        background:#3bb4f2;color: #fff;padding: 0 6px;margin: 0 5px;border-radius: 2px"> 0 </span>页， 共<span id="total-pages-num" style="font-size: 14px;
        background:#3bb4f2;color: #fff;padding: 0 6px;margin: 0 5px;border-radius: 2px"> 0 </span>页</p>
    </div>
    <div id="task-pagination" class="btn-wrapper" style="float: right;margin-top: 40px">
        <div id="task-first-page" type="button" class="am-btn am-round am-btn-secondary am-btn-xs">首页</div>
        <div id="task-prev-page" type="button" class="am-btn am-round am-btn-secondary am-btn-xs">上一页</div>
        <div id="task-next-page" type="button" class="am-btn am-round am-btn-secondary am-btn-xs">下一页</div>
        <div id="task-last-page" type="button" class="am-btn am-round am-btn-secondary am-btn-xs">末页</div>
    </div>
</div>