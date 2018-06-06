<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/6
 * Time: 16:20
 */
namespace task;

class Controller_Report extends Controller_baseController
{

    public function get_index(){
        return \Response::forge(\View::forge('default/report/index'));
    }
}