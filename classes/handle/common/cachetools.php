<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 17-2-27
 * Time: 下午6:35
 */

namespace handle\common;


class CacheTools
{
    private static $redis = false;
    /**
     * 获取缓存数据
     *
     * @param $key                      缓存键
     * @param bool $default_value       缓存内容
     * @return bool
     */
    public static function get_value($key, $default_value = false){
        $value = $default_value;
        try {
            $value = \Cache::get($key);
        } catch (\CacheNotFoundException $e) {
            // 缓存未找到
            if(strpos($key, 'global_config_') !== false){

            }
        } catch (\FuelException $e) {
            // 缓存键是否合法
        }

        return $value;
    }

    public static function get($key, $default_value = false){

        $redis = \Redis_Db::instance();

        if ( ! $value = $redis->get($key)){
            $value = $default_value;
        }

        return $value;

    }

    public static function set($key, $value, $expiration = false){

        $redis = \Redis_Db::instance();

        if ($expiration){
            $result = $redis->set($key, $value, 'EX', $expiration);
        } else {
            $result = $redis->set($key, $value);
        }

        return $result;
    }

    public static function delete($key){

        $redis = \Redis_Db::instance();

        return $redis->del($key);
    }


    /** Redis 集合
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function s_add($key, $value){

        $redis = \Redis_Db::instance();

        $result = $redis->sadd($key, $value);

        return $result;
    }

    public static function s_randmember($key){

        $redis = \Redis_Db::instance();

        $result = $redis->srandmember($key);

        return $result;
    }

    public static function instance($name = 'default', $config = []){

        isset(static::$redis) and \Config::load('db', true);

        if ( ! ($conf = \Config::get('db.redis.'.$name)))
        {
            throw new \RedisException('Invalid instance name given.');
        }
        $config = \Arr::merge($conf, $config);

        if (static::$redis == null){
            static::$redis = new \Redis();
            static::$redis->pconnect($config['hostname'], $config['port']);
            static::$redis->select($config['database']);
        }

        return static::$redis;
    }

}