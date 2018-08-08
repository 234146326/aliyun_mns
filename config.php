<?php
//配置参考
return [
    'captchaNum'=>4,
    'accessKeyId'=>'AK',
    'accessKeySecret'=>'AS',
    'SendSms' =>[
        "RegionId" => "cn-hangzhou",
        "Action" => "SendSms",
        "Version" => "",
        "SignName" => "我居定制",// fixme 必填: 短信签名
        'PhoneNumbers'=>'',// fixme 必填: 短信接收号码
        'TemplateParam'=>[],//fixme 可选: 设置模板参数,idea:['code'=>'SMS_61200089','customer'=>'yadan']
        'TemplateCode'=>'',//fixme 模板 Code
        'OutId'=>'12345',// fixme 可选: 设置发送短信流水号
        'SmsUpExtendCode'=>'1234567', // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽
        'domain'=>'dysmsapi.aliyuncs.com',// fixme API接口所在域名
    ],
    'querySendDetails'=>[
        'PhoneNumber'=>'', // fixme 必填: 短信接收号码
        'SendDate'=>'', // fixme 必填: 短信发送日期，格式Ymd，支持近30天记录查询
        'PageSize'=>10, // fixme 必填: 分页大小
        'CurrentPage'=>1, // fixme 必填: 当前页码
        'BizId'=>''  // fixme 可选: 设置发送短信流水号
    ],
    'sms_temp_conf'=>[
        //fixme 短信模板配置文件
        //validate_ip fixme 是否过滤相同IP不重复发送 true
        //dev 变量名=>值 fixme code 短信模板的代码，其它键为短信模板的定义变量。
        'validate_ip'=>true,
//        'dev'=>['code'=>'SMS_61200089','customer'=>'测试先生'],
    ],











];