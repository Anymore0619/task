<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/6
 * Time: 16:11
 */
namespace task;

class Controller_Home extends Controller_baseController{

    public function get_index(){
        $user = \Auth::get_user();

        if($user['group_id'] == 1){
            \Response::redirect("/task/project");
        }else if(in_array($user['group_id'],[4,7])){
            \Response::redirect("/task/report");
        }
    }

}
