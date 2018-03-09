<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

/**
 * Class AppQueryRequest
 *
 * @package Omnipay\Alipay\Message
 */
class AppQueryRequest extends AbstractAppRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate(
            'app_id',
            'rsa_private_key',
            'sign_type',
            'alipay_rsa_public_key',
            'out_trade_no'
        );

        $data = array(
            "app_id"                => $this->getAppId(),
            "rsa_private_key"       => $this->getRsaPrivateKey(),
            "sign_type"             => $this->getSignType(),
            "alipay_rsa_public_key" => $this->getAlipayRsaPublicKey(),
            "out_trade_no"          => $this->getOutTradeNo(),
        );

        return $data;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {

        $aop                     = new \AopClient ();
        $aop->gatewayUrl         = $this->getEndpoint();
        $aop->appId              = $data['app_id'];
        $aop->rsaPrivateKey      = $data['rsa_private_key'];
        $aop->alipayrsaPublicKey = $data['alipay_rsa_public_key'];
        $aop->apiVersion         = '1.0';
        $aop->signType           = $data['sign_type'];
        $aop->postCharset        = 'UTF-8';
        $aop->format             = 'json';
        $request                 = new \AlipayTradeQueryRequest ();

        $biz_content = array(
            "out_trade_no"    => $data['out_trade_no'],
        );

        $biz_content = json_encode($biz_content);

        $request->setBizContent($biz_content);

        $result = $aop->execute($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode   = $result->$responseNode->code;
        $trade_status   = $result->$responseNode->trade_status;

        if (! empty($resultCode) && $resultCode == 10000 && $trade_status == 'TRADE_SUCCESS') {
            $data['is_paid'] = true;
        } else {
            $data['is_paid'] = false;
        }

        return array_merge($data, (array) $result->$responseNode);
    }
}
