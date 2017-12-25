<?php

$app->get('/', function () {
    sendContent('ok', 'test ok');
});

$app->get('/sms/{appname}/vcode/{id:[0-9]+}', function ($appName, $mobile) use ($app) {
    sendVCode($appName, $mobile);
});

$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->send();
});

function sendContent($status, $messages=null) {
    global $app;

    $messages = $messages ?? STATUS[$status]['message'] ?? '无话可说';
    $app->response->setJsonContent([
        'code' => STATUS[$status]['code'],
        'status' => $status,
        'detail' => $messages,
    ]);

    $app->response->send();
}

function sendVCode($appName, $mobile) {
    global $app;

    $provider = $app->smsProvider;
    $result = $provider->sendVCode($mobile);

    if ($result[0] === 'ok') {
        $sendId = $result[2];
    } else {
        $sendId = 0;
    }

    $app->logger->info(
        $app->request->getClientAddress() . ',' .
        $app->request->getURI() . ',' .
        json_encode([
            $provider->providerName,
            'vcode',
            $provider->config['templates']['vcode']['id'],
        ]) . ',' .
        json_encode($result[1]) . ',' .
        $result[0] . ',' .
        $sendId
    );

    sendContent($result[0], $result[1]);
}

