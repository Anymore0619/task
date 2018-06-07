<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/6
 * Time: 16:20
 */
namespace task;
use \Model_Project;
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

    public function get_tasks(){
        $action = \Input::get('action');
        $data = [];
        $users = \DB::query('SELECT * FROM users')->execute();
        if($action === 'all'){
            $data = \DB::query('SELECT * FROM tasks')->execute();
        }

        Model_Project::get_query();

        die;
        \View::set_global([
            'title'     =>  '主页',
            'data'      =>  $data,
            'users'     =>  $users
        ]);
        $this->template->content = \View::forge('default/project/view');
    }
}