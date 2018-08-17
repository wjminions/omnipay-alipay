<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class MobileResponse
 * @package Omnipay\Alipay\Message
 */
class MobileRefundResponse extends AbstractResponse
{

    public function isRedirect()
    {
        return false;
    }


    public function getRedirectMethod()
    {
        return 'POST';
    }


    public function getRedirectUrl()
    {
        return false;
    }


    public function getRedirectHtml()
    {
        return false;
    }


    public function getTransactionNo()
    {
        return isset($this->data['trade_no']) ? $this->data['trade_no'] : '';
    }


    public function isPaid()
    {
        if ($this->data['is_paid']) {
            return true;
        }

        return false;
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if ($this->data['is_paid']) {
            return true;
        }

        return false;
    }

    public function getMessage()
    {
        return isset($this->data['sub_msg']) ? $this->data['sub_msg'] : $this->data['msg'];
    }
}
