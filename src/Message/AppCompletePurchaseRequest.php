<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

/**
 * Class AppCompletePurchaseRequest
 * @package Omnipay\Alipay\Message
 */
class AppCompletePurchaseRequest extends AbstractAlipayRequest
{

    protected $endpoint = 'http://notify.alipay.com/trade/notify_query.do?';

    protected $endpointHttps = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';

    public function getData()
    {
        $this->validateParam('sign_type', 'sign', 'out_trade_no');

        $transport = strtolower($this->getTransport() ?: 'http');
        $signType  = $this->getRequestParam('sign_type');

        if ($transport == 'https') {
            $this->validate('ca_cert_path');
        }

        if ($signType == 'MD5') {
            $this->validate('key');
        } else {
            $this->validate('private_key');
        }

        $data = array (
            'request_params' => $this->getRequestParams()
        );

        return $data;
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function sendData($data)
    {
        $data = $this->getRequestParams();

        $signType = strtoupper($this->getRequestParam('sign_type'));

        $sign = Helper::sign($data, $signType, $this->getSignKey($signType));

        $notifyId = $this->getRequestParam('notify_id');

        /**
         * is sign match?
         */
        if (isset($data['sign']) && $data['sign'] && $sign === $data['sign']) {
            $signMatch = true;
        } else {
            $signMatch = false;
        }

        /**
         * Verify through Alipay server if exists notify_id
         */
        if ($notifyId) {
            $verifyResponse = $this->getVerifyResponse($notifyId);
            $verifyOk       = $this->isNotifyVerifiedOK($verifyResponse);
        } else {
            $verifyOk = true;
        }

        /**
         * is paid?
         */
        if ($signMatch && $verifyOk && isset($data['trade_status']) && $data['trade_status'] == 'TRADE_FINISHED') {
            $paid = true;
        } else {
            $paid = false;
        }

        $responseData = array (
            'sign_match'          => $signMatch,
            'notify_id_verify_ok' => $verifyOk,
            'paid'                => $paid,
        );

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }
}
