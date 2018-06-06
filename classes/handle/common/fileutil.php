<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 2017/9/3
 * Time: 16:43
 */

namespace handle\common;


class FileUtil
{
    /**
     * 检测指定目录中，按日期创建的层级目录是否存在
     * 目录示例：$root/2017/09/03/
     *
     * @param   string $root        根目录
     * @param   string $sub_path    子目录
     * @return string
     */
    public static function handle_date_path($root, $sub_path){
        $ds = DS;
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $date_path = "{$year}{$ds}{$month}{$ds}{$day}{$ds}";

        # 检测目录是否存在
        $path = "{$root}{$sub_path}{$date_path}";

        if( ! is_dir($path)){

            if ( ! is_dir("{$root}{$sub_path}")){

                try{
                    \File::create_dir("{$root}", "{$sub_path}");
                }catch (\Exception $e){
                    \Log::error("创建目录时，发生异常：" . $e->getMessage());
                }
            }

            try{
                \File::create_dir("{$root}{$sub_path}", "{$date_path}");
            }catch (\Exception $e){
                \Log::error("创建目录时，发生异常：" . $e->getMessage());
            }
        }

        return $date_path;
    }
}