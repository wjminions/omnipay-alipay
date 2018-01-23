<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

/**
 * Class AppRefundRequest
 *
 * @package Omnipay\Alipay\Message
 */
class AppRefundRequest extends AbstractAppRequest
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
            'out_trade_no',
            'refund_amount',
            'out_request_no',
            'trade_no'
        );

        $data = array(
            "app_id"                => $this->getAppId(),
            "rsa_private_key"       => $this->getRsaPrivateKey(),
            "sign_type"             => $this->getSignType(),
            "alipay_rsa_public_key" => $this->getAlipayRsaPublicKey(),
            "out_trade_no"          => $this->getOutTradeNo(),
            "refund_amount"         => $this->getRefundAmount(),
            "out_request_no"        => $this->getOutRequestNo(),
            'trade_no'              => $this->getTradeNo(),
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
        $request                 = new \AlipayTradeRefundRequest ();

        $biz_content = array(
            "out_trade_no"   => $data['out_trade_no'],
            "trade_no"       => $data['trade_no'],
            "refund_amount"  => $data['refund_amount'],
            "out_request_no" => $data['out_request_no'],
        );

        $biz_content = json_encode($biz_content);

        $request->setBizContent($biz_content);
        $result = $aop->execute($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode   = $result->$responseNode->code;

        if (! empty($resultCode) && $resultCode == 10000) {
            $data['is_paid'] = true;
        } else {
            $data['is_paid'] = false;
        }

        return $this->response = new AppRefundResponse($this, array_merge($data, (array)$result->$responseNode));
    }
}
