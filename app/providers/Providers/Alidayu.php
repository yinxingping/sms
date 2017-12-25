<?php

namespace Sms\Providers;

/*
 * @todo 还没有实现查询发送状态的功能
 */
class Alidayu
{

    public static function sendVCode($mobile, $vcode, $appKey, $appSecret, $template)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
        ];

        $data = [
            'app_key' => $appKey,
            'sign_method' => 'md5', //createSign中使用md5进行加密
            'sms_template_code' => $template['id'],
            'sms_free_sign_name' => $template['signName'],
            'partner_id' => 'apidoc',
            'timestamp' => date('Y-m-d H:i:s'),
            'sms_type' => 'normal',
            'v' => '2.0',
            'format' => 'json',
            'method' => 'alibaba.aliqin.fc.sms.num.send',
            'rec_num' => $mobile,
        ];
        $data['sms_param'] = json_encode(['number' => $vcode]);
        $data['sign'] = self::generateSign($appSecret, $data);

        $response = \Requests::post($template['api'], $headers, $data);
        if ($response->success) {
            $body = json_decode($response->body, true);
            if (isset($body['error_response'])) {
                $errorResp = $body['error_response'];
                $return = [
                    'sms_provider_error',
                    [
                        'code' => $errorResp['code'],
                        'message' => $errorResp['msg'],
                        'type' => $errorResp['sub_code'],
                    ],
                ];
            } else {
                $return = [
                    'ok',
                    ['vcode' => $vcode],
                    $body['alibaba_aliqin_fc_sms_num_send_response']['request_id']
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

    private static function generateSign($appSecret, &$data)
    {
        $sign = $appSecret;
        ksort($data);
        foreach ($data as $k => $v) {
            if ($k!= '' && $v != '') {
                $sign .= $k . $v;
            }
        }
        $sign .= $appSecret;
        $sign = strtoupper(md5($sign));

        return $sign;
    }

}

