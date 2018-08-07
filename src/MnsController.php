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
     * @param string $moblie fixme 手机号
     */
    public function index($moblie = "15692008099")
    {
        //
        $codeName = 'SMS_61200089';//fixme 模板代码名称
        $temp_body = ['customer'=>'测试先生'];//fixme 模板变量
        $xuSendSms = new \aliyun_mns\app\xuSendSms([
            'accessKeyId'=>'',
            'accessKeySecret'=>'',
            'sendSms'=>[
                'SignName'=>''//fixme 短信签名
            ],
        ]);
        $xuSendSms->index($codeName,$moblie,$temp_body);
    }
}