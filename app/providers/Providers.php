<?php

namespace Sms;

class Providers
{
    public $providerName;
    public $config;
    private $provider;

    public function __construct($providerName, $config)
    {
        $this->providerName = $providerName;
        $this->config = $config;
        $this->provider = $config['class'];
    }

    public function sendVCode($mobile)
    {
        return ($this->provider)::sendVCode(
            $mobile,
            self::generateVCode($this->config['templates']['vcode']['vcodeSize']),
            $this->config['appKey'],
            $this->config['appSecret'],
            $this->config['templates']['vcode']
        );
    }

    private static function generateVCode($vcodeSize)
    {
        $vcode = rand(1,9);
        for ($i = 1; $i < $vcodeSize; $i++) {
            $vcode .= rand(0, 9);
        }

        return $vcode;
    }

}

