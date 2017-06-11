<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\mns;

use think\Config;

class MnsController
{
    /**
     * @param string $moblie
     * @param string $meg
     */
    public function index($moblie = "",$meg = "")
    {
        require_once('../mns-autoloader.php');
        $mns = new Mns((array)Config::get('mns'));
        $mns->run("dev",[$moblie=>array("customer" => $meg)]);
    }
}