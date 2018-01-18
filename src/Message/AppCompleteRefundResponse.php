<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class AppCompletePurchaseResponse
 * @package Omnipay\Alipay\Message
 */
class AppCompleteRefundResponse extends AbstractResponse
{

    public function isPaid()
    {
        return $this->data['is_paid'] && $this->data['data']['object']['succeed'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['is_paid'] && $this->data['data']['object']['succeed'];
    }
}
