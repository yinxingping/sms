<?php

namespace Sms\Providers;

class Netease
{

    public static function sendVCode($mobile, $vcode, $appKey, $appSecret, $template)
    {
        $curTime = time();
        $nonce = md5(time());

        $headers = [
            'AppKey' => $appKey,
            'CurTime' => $curTime,
            'Nonce' => $nonce,
            'CheckSum' => sha1($appSecret . $nonce . $curTime),
            'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
        ];

        $data = [
            'mobile' => $mobile,
            'templateid' => $template['id'],
            'authCode' => $vcode,
        ];

        $response = \Requests::post($template['api'], $headers, $data);
        if ($response->success) {
            $body = json_decode($response->body, true);
            if ($body['code'] == '200') {
                $return = [
                    'ok',
                    ['vcode' => $vcode],
                    $body['msg'],
                ];
            } else {
                $return = [
                    'sms_provider_error',
                    $body,
                ];
            }
        } else {
            $return = [
                'network_error',
                [
                    'code' => $response->status_code,
                    'message' => STATUS['network_error']['message'],
                    'type' => 'network_error',
                ]
            ];
        }

        return $return;
    }

}

