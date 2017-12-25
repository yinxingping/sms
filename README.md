# 主要功能

使用 [simpleapi项目模板](https://github.com/yinxingping/my-phalcon-devtools) 开发的短信发送API

## 具体环境要求

1. PHP框架：Phalcon >= 3.2
2. 开发工具：[my-phalcon-devtools](https://github.com/yinxingping/my-phalcon-devtools)

## 其他事项
1. 框架中提供了阿里大于和网易云短信两个短信服务提供者，阿里大于已经过测试，网易云短信需要进一步测试；
2. 目前仅提供了验证码短信功能；
3. 添加短信提供商的方法：

    ``` 
    1）app/providers/Providers/下添加相应的类（参考Alidayu.php）
    2）app/config/config.php的smsProviders下增加提供商参数
    3）.env中指定SMS_PROVIDER_NAME
    
    ```
