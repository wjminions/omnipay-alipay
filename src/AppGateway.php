<?php

namespace Omnipay\Alipay;

use Omnipay\Common\AbstractGateway;

/**
 * Class AppGateway
 * @package Omnipay\Alipay
 */
class AppGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return ' Alipay APP gateway';
    }


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
        return $this->setParameter('alipay_rsa_public_key', $value);
    }

    public function getAlipayRsaPublicKey()
    {
        return $this->getParameter('alipay_rsa_public_key');
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


    public function setRefundAmount($value)
    {
        return $this->setParameter('refund_amount', $value);
    }

    public function getRefundAmount()
    {
        return $this->getParameter('refund_amount');
    }


    public function setOutRequestNo($value)
    {
        return $this->setParameter('out_request_no', $value);
    }

    public function getOutRequestNo()
    {
        return $this->getParameter('out_request_no');
    }


    public function setTradeNo($value)
    {
        return $this->setParameter('trade_no', $value);
    }

    public function getTradeNo()
    {
        return $this->getParameter('trade_no');
    }


    public function purchase(array $parameters = array ())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\AppPurchaseRequest', $parameters);
    }


    public function completePurchase(array $parameters = array ())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\AppCompletePurchaseRequest', $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\AppQueryRequest', $parameters);
    }


    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\AppRefundRequest', $parameters);
    }


    public function completeRefund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Alipay\Message\AppCompleteRefundRequest', $parameters);
    }
}
