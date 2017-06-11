<?php

namespace think\mns;

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

/**
 * Class Mns
 * @package think\mns
 */
class Mns
{
    /**
     * @var array
     */
    protected $config = [
        'seKey'    => 'https://github.com/234146326/aliyun_mns',
        'accessId'    => '必填',
        'accessKey'    => '必填',
        'endPoint'    => '必填',
        'topicName'    => '必填',
        "SMS" =>[
            "dev" => ["SMSSignName","SMSTemplateCode"],
            "master" => ["SMSSignName1","SMSTemplateCode1"],
        ]
    ];

    protected $client;

    /**
     * Mns constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 使用 $this->name 获取配置
     * @access public
     * @param  string $name 配置名称
     * @return mixed    配置值
     */
    public function __get($name)
    {
        return $this->config[$name];
    }

    /**
     * 设置验证码配置
     * @access public
     * @param  string $name  配置名称
     * @param  string $value 配置值
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 检查配置
     * @access public
     * @param  string $name 配置名称
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * @param string $smsName
     * @param array $moblie
     */
    public function run($smsName="",$moblie=[])
    {
        /**
         * Step 1. 初始化Client
         */
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);
        /**
         * Step 2. 获取主题引用
         */
        $topic_name = $this->topicName;
        $topic = $this->client->getTopicRef($topic_name);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($this->SMS[$smsName][0], $this->SMS[$smsName][1]);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        //批量的群发 ["15888888888"=>["变量1"=>值,"变量2"=>值 .......],"13000000000"=>["变量1"=>值,"变量2"=>值 .......],]
        //$item 手机号 && $value 对应变量与值
        foreach ($moblie as $item=>$value){
            $batchSmsAttributes->addReceiver($item, $value);
        }


        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
        $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try
        {
            $res = $topic->publishMessage($request);
            echo $res->isSucceed();
            echo "\n";
            echo $res->getMessageId();
            echo "\n";
        }
        catch (MnsException $e)
        {
            echo '错误';
            echo "\n";
            echo $e;
            echo "\n";
        }
    }
}
?>