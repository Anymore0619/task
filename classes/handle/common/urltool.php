<?php

namespace handle\common;

class UrlTool{

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     *
     * @param array $para   需要拼接的数组
     * @return bool|string  拼接完成以后的字符串
     */
    public static function createLinkstring($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.= "{$key}={$val}&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     *
     * @param array $para   需要拼接的数组
     * @return bool|string  拼接完成以后的字符串
     */
    public static function createLinkstringUrlencode($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 模拟GET请求
     *
     * @param $url              链接地址
     * @param bool $options
     * @param bool $headers
     * @return bool
     */
    public static function request_get($url, $options = false, $headers = false){
        return static::request($url, 'GET', false, false, $options, $headers);
    }

    /**
     * 模拟POST请求
     *
     * @param $url              链接地址
     * @param $params           参数
     * @param bool $options
     * @param bool $headers
     * @return bool
     */
    public static function request_post(
        $url,
        $params,
        $options = false,
        $headers = false){
        return static
            ::request(
                $url,
                'POST',
                $params,
                false,
                $options,
                $headers);
    }

    /**
     * 模拟GET或POST发送请求
     * 并获取返回值
     *
     * @param string $url       链接
     * @param string $method    链接方式
     * @param array $params     参数
     * @param bool $mime
     * @param array $options
     * @param array $headers
     * @return bool
     */
    public static function request(
        $url,
        $method = 'GET',
        $params = array(),
        $mime = false,
        $options = array(),
        $headers = array()
    ){

        if ( ! $url){
            die('错误的URL');
        }
        $curl = \Request::forge($url, 'curl');
        $curl->set_method($method);

        if (stripos($url, 'https://') !== false){
            $curl->set_option(CURLOPT_SSL_VERIFYPEER, false);
        }

        if ($options){
            $curl->set_options($options);
        }

        if ($mime){
            $curl->set_mime_type($mime);
        }

        if ($headers){
            foreach ($headers as $key => $value) {
                $curl->set_header($key, $value);
            }
        }

        $curl->set_options(array(
                CURLOPT_TIMEOUT => 30
            )
        );

        if ($params){
            $curl->set_params($params);
        }

        $result = false;

        try {
            $result = $curl->execute()->response();
        } catch (\Exception $e){
            \Log::error("发送请求时，发生了异常(urltool/request)【{$url}】：" . $e->getMessage());
            die($e->getMessage());
        }

        return $result;
    }

    /**
     * 模拟GET或POST XML到直接URL
     *
     * @param   string   $url       需要发送的地址
     * @param   string   $method    请求方式
     * @param   array    $params    请求参数
     * @return bool
     */
    public static function request_xml($url, $method = 'POST', $params){

        $curl = \Request::forge($url, 'curl');
        $curl->set_method($method);

        if ($params){
            $curl->set_params($params);
        }
        if (stripos($url, 'https://') !== false){
            $curl->set_option(CURLOPT_SSL_VERIFYPEER, false);
            $curl->set_option(CURLOPT_SSL_VERIFYHOST, false);
        }

        $curl->set_options(array(
                CURLOPT_TIMEOUT => 30,
                //CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HEADER => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
            )
        );

        $result = false;

        try {
            $result = $curl->execute()->response();
        } catch (\Exception $e){
            \Log::error("发送请求时，发生了异常(urltool/request_xml)【{$url}】：" . $e->getMessage());
        }

        return $result;
    }
}