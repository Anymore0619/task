<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/5
 * Time: 11:24
 */

namespace task;


class Controller_Auth extends Controller_baseController
{
    public function get_index(){
       die;
    }

    public function get_login(){
        \View::set_global([
           'title'  =>  '登陆'
        ]);
        $this->template->content = \View::forge('default/login');
        //return \Response::forge(\View::forge('default/login'));
    }

    public function get_logout(){
        \Auth::logout();
        \View::set_global([
            'title'  =>  '登陆'
        ]);
        $this->template->content = \View::forge('default/login');
    }
}