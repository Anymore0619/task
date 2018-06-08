<?php
/**
 * Created by PhpStorm.
 * User: liaosiqun
 * Date: 2018/6/7
 * Time: 10:35
 */
class Model_Project extends Model_Base
{
    protected static $_table_name = 'projects';

    protected static $_primary_key = array('id');

    protected static $_has_many = array('tasks' => array(
        'model_to'  =>  'Model_Task',
        'key_from'  =>  'id',
        'key_to'    =>  'project_id',
        'cascade_save'  =>  true,
        'cascade_delete'  =>  false
    ));
}