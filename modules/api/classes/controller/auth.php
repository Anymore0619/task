<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/5
 * Time: 14:57
 */

namespace api;
class Controller_Auth extends Controller_BaseController
{
    public function post_login(){
        $data = \Input::post();
        $msg = '';
        if(isset($data)){
            if( ! $data['username'] || ! $data['password']){
                $msg = '请填写用户名或密码';
            }
        }else{
            $msg = '缺少参数';
        }


        if($msg){
            return [
                'status'  => 'err',
                'msg'     => $msg,
                'errcode' => 1
            ];
        }


        if(\Auth::login($data['username'],base64_decode($data['password']))){
            return [
                'status'  => 'succ',
                'msg'     => '',
                'errcode' => 0
            ];
        }

        return [
            'status'  => 'err',
            'msg'     => '用户名或密码错误',
            'errcode' => 1
        ];

    }

    public function post_logout(){
        \Auth::logout();
    }
}