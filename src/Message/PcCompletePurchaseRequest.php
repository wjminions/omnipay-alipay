<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

/**
 * Class PcCompletePurchaseRequest
 * @package Omnipay\Alipay\Message
 */
class PcCompletePurchaseRequest extends AbstractAppRequest
{
    public function getData()
    {
        return $this->getRequestParams();
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = $this->getAlipayRsaPublicKey();
        $flag = $aop->rsaCheckV1($_POST, NULL, $this->getSignType());

        $data['is_paid'] = false;
        if ($flag && $data['trade_status'] == 'TRADE_SUCCESS') {
            // 验证通过
            $data['is_paid'] = true;

            http_response_code(200);
            echo 'success';
        }

        return $this->response = new PcCompletePurchaseResponse($this, $data);
    }
}
