<?php
/**
 * ===============================================================
 */

namespace think\mns;

use think\Config;

/**
 * Class MnsController
 * @package think\mns
 */
class MnsController
{
    /**
     * @param string $moblie
     * @param string $meg
     */
    public function index($moblie = "",$meg = "")
    {
        $new_mns = new Mns((array) Config::get('mns'));
        $new_mns->run("dev",[$moblie=>array("customer" => $meg)]);
    }
}