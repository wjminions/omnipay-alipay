<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

class PcPurchaseRequest extends AbstractAppRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array(
            "app_id"                => $this->getAppId(),
            "rsa_private_key"       => $this->getRsaPrivateKey(),
            "sign_type"             => $this->getSignType(),
            "alipay_rsa_public_key" => $this->getAlipayRsaPublicKey(),
            "subject"               => $this->getSubject(),
            "body"                  => $this->getBody(),
            "out_trade_no"          => $this->getOutTradeNo(),
            "timeout_express"       => $this->getTimeoutExpress(),
            "total_amount"          => $this->getTotalAmount(),
        );

        return $data;
    }


    private function validateData()
    {
        $this->validate(
            'app_id',
            'rsa_private_key',
            'sign_type',
            'alipay_rsa_public_key',
            'subject',
            'body',
            'out_trade_no',
            'timeout_express',
            'total_amount'
        );
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $aop = new \AopClient();

        $aop->gatewayUrl    = $this->getEndpoint();
        $aop->appId         = $data['app_id'];
        $aop->rsaPrivateKey = $data['rsa_private_key'];
        $aop->apiVersion    = '1.0';
        $aop->signType      = $data['sign_type'];
        $aop->postCharset   = "UTF-8";
        $aop->format        = "json";
        //        $aop->alipayrsaPublicKey = $data['alipay_rsa_public_key'];
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.page.pay
        $request = new \AlipayTradePagePayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $biz_content = array(
            "body"            => $data['body'],
            "subject"         => $data['subject'],
            "out_trade_no"    => $data['out_trade_no'],
            "timeout_express" => $data['timeout_express'],
            "total_amount"    => $data['total_amount'],
            "product_code"    => "FAST_INSTANT_TRADE_PAY",
        );

        $biz_content = json_encode($biz_content);

        $request->setNotifyUrl($this->getNotifyUrl());
        $request->setReturnUrl($this->getNotifyUrl());
        $request->setBizContent($biz_content);

        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->pageExecute($request);

        return $this->response = new PcPurchaseResponse($this, $response);
    }
}
