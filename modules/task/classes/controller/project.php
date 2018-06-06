<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/6
 * Time: 16:20
 */
namespace task;

class Controller_Project extends Controller_baseController
{

    public function get_index(){
        $data = \DB::query('SELECT * FROM projects')->execute();

        \View::set_global([
            'title'     =>  '主页',
            'data'      =>  $data
        ]);
        $this->template->content = \View::forge('default/project/index');
    }

    public function get_all_tasks(){
        $data = \DB::query('SELECT * FROM tasks')->execute();
        \View::set_global([
            'title'     =>  '主页',
            'data'      =>  $data
        ]);
        $this->template->content = \View::forge('default/project/view');
    }
}