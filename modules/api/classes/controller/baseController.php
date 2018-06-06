<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/5
 * Time: 14:54
 */

namespace api;
use \handle\common\UrlTool;

class Controller_BaseController extends \Fuel\Core\Controller_Rest
{
    public function before(){
        parent::before();
    }

}