<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 9:51
 */

namespace aliyun_mns\app;

use aliyun_mns\SignatureHelper;

/**
 * Class xuSendSms
 * @package aliyun_mns\app
 */
class xuSendSms  extends SignatureHelper
{
    /**
     * xuSendSms constructor.
     * @param array $config
     */
    public function __construct($config=[])
    {
        //....
        $this->options = require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR . 'config.php';
        $this->config = count($config)?array_merge($this->options['SendSms'],$config):$this->options['SendSms'];
    }

    /**
     * @var
     */
    protected $options;
    /**
     * @var array
     */
    protected $config  = [];

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->config[$name];
    }


    /**
     * @param string $type string 模板名称
     * @param int $mobileNum float 手机号
     * @param bool $msg_captcha
     * @return array
     */
    public function index($type='',$mobileNum = 0,$temp_body = [])
    {;
        if(!is_numeric($mobileNum)){
            exit('Phone Number Error or Undefined');
        }
        ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
        set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
        header("Content-Type: text/plain; charset=utf-8"); // 输出为utf-8的文本格式，仅用于测试
        // 验证发送短信(SendSms)接口
        $sms_return = $this->sendSms($type,$mobileNum,$temp_body);//$temp_body 短信发送的内容数组，细节请参考短信模板填写
        $sms_arr = $this->objectToArray($sms_return);
        return $sms_arr;
    }

    /**
     * 返回验证码 Return Captcha
     * @param int $captcha_num int 验证码长度
     * @return int
     */
    private function register_captcha($captcha_num = 4)
    {
        $count=[];
        for($i =0;$i<$captcha_num; $i++){
            $count[] =rand(1, 9);
        }
        $captcha = (int) implode("",$count);
        return $captcha;
    }

    /**
     * fixme actine sms event
     * fixme return bool | stdClass
     * @param $type
     * @param $mobileNum
     * @param $temp_body
     * @return mixed
     */
    private function sendSms($type,$mobileNum,$temp_body)
    {
        (!empty($type)) or exit('sms type empty error');
        $params = $this->getSmsConfig($type,$mobileNum,$temp_body);
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 此处可能会抛出异常，注意catch
        $content = $this->signatureHelper->request(
            $this->accessKeyId,
            $this->accessKeySecret,
            $this->domain,
            $params
        );

        return $content;
    }


    /**
     * 添加
     * fixme 获取短信配置模板 $temp_body 数组
     * @param string $sms_type fixme:模板名称代码
     * @return array fixme 返回短信数组配置
     */
    public function getSmsConfig($sms_type='',$mobileNum,$temp_body)
    {
        $arr = $this->options['sms'];$sms_con=[];
        foreach ($arr as $key=>$value) //...
        {
            if($sms_type === $key){
                $sms_con =  $arr[$key];break;
            }else{
                continue;
            }
        }
        $parmas = [];
        $parmas['PhoneNumbers']= $mobileNum;
        $parmas['TemplateCode']= $sms_con['code'];//模板名称代码 temp name code
        $parmas['TemplateParam']= array_merge($sms_con,$temp_body);
        return array_merge($this->config,$parmas);
    }

    /**
     * 对象转换数组
     * @param $object
     * @return mixed
     */
    function objectToArray(&$object) {
        $object =  json_decode(json_encode($object),true);
        return  $object;
    }

}