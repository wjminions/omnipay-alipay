<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Alipay\Helper;

/**
 * Class AbstractAppRequest
 * @package Omnipay\Alipay\Message
 */
abstract class AbstractAppRequest extends AbstractRequest
{
    public function setSignType($value)
    {
        return $this->setParameter('sign_type', $value);
    }

    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }


    public function setRsaPrivateKey($value)
    {
        return $this->setParameter('rsa_private_key', $value);
    }

    public function getRsaPrivateKey()
    {
        return $this->getParameter('rsa_private_key');
    }


    public function setAlipayRsaPublicKey($value)
    {
        return $this->setParameter('rsa_alipay_public_key', $value);
    }

    public function getAlipayRsaPublicKey()
    {
        return $this->getParameter('rsa_alipay_public_key');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }

    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setAppId($value)
    {
        return $this->setParameter('app_id', $value);
    }

    public function getAppId()
    {
        return $this->getParameter('app_id');
    }


    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    public function setOutTradeNo($value)
    {
        return $this->setParameter('out_trade_no', $value);
    }

    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }

    public function getSubject()
    {
        return $this->getParameter('subject');
    }


    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }

    public function getBody()
    {
        return $this->getParameter('body');
    }


    public function setTotalAmount($value)
    {
        return $this->setParameter('total_amount', $value);
    }

    public function getTotalAmount()
    {
        return $this->getParameter('total_amount');
    }


    public function setTimeoutExpress($value)
    {
        return $this->setParameter('timeout_express', $value);
    }

    public function getTimeoutExpress()
    {
        return $this->getParameter('timeout_express');
    }
}
