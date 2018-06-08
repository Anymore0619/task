<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/8
 * Time: 11:23
 */
namespace task;
use \Model_Task;
class Controller_Task extends Controller_baseController
{
    public function get_list(){
        $action = \Input::get('action');
        $user_id = \Auth::get_user()['user_id'];
        $data = [];

        $users = \DB::query('SELECT * FROM users')->execute();

        if($action === 'all'){
            $data = Model_Task::find('all');
        }else if($action === 'my'){
            $data = Model_Task::find('all',array(
                'where' =>  array(
                    array('user_id',$user_id)
                )
            ));
        }else if($action === 'assign'){
            $data = Model_Task::find('all',array(
                'where' =>  array(
                    array('publisher_id',$user_id)
                )
            ));
        }else if($action === 'item'){
            $project_id = \Input::get('project_id');
            $data = Model_Task::find('all',array(
                'where' =>  array(
                    array('project_id',$project_id)
                )
            ));
        }


        var_dump($data);

        die;
        \View::set_global([
            'title'     =>  '主页',
            'data'      =>  $data,
            'users'     =>  $users
        ]);
        $this->template->content = \View::forge('default/task/view');
    }
}