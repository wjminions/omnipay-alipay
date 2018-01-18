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
            'app_key',
            'order_no'
        );

        $data = array(
            //app_id
            'app'              => $this->getApp(),
            //支付方式
            'channel'          => $this->getChannel(),
            //callback地址
            'callback'         => $this->getCallback(),
            //app_key
            'app_key'          => $this->getAppKey(),
            //货币
            'currency'         => $this->getCurrency(),
            //私钥地址
            'private_key_path' => $this->getPrivateKeyPath(),
            //交易id
            'order_no'         => $this->getOrderNo()
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

        \Alipay\Alipay::setApiKey($data['app_key']);           // 设置 API Key
        \Alipay\Alipay::setPrivateKeyPath($data['private_key_path']);   // 设置私钥

        // 查询支付成功列表
        $ch = \Alipay\App::all(array(
            'limit'    => 10,
            'app'      => array('id' => $data['app']),
            'channel'  => $data['channel'],
            'paid'     => true,
            'refunded' => false,
            'reversed' => false
        ));

        $data['is_paid'] = false;

        foreach ($ch->data as $App) {
            if ($App['order_no'] == $data['order_no'] && $App['paid'] && ! $App['refunded'] && ! $App['reversed']) {
                $data['is_paid'] = true;

                $data['id']              = $App->id;
                $data["object"]          = $App->object;
                $data["created"]         = $App->created;
                $data["livemode"]        = $App->livemode;
                $data["paid"]            = $App->paid;
                $data["refunded"]        = $App->refunded;
                $data["reversed"]        = $App->reversed;
                $data["app"]             = $App->app;
                $data["channel"]         = $App->channel;
                $data["client_ip"]       = $App->client_ip;
                $data["amount"]          = $App->amount;
                $data["amount_settle"]   = $App->amount_settle;
                $data["currency"]        = $App->currency;
                $data["subject"]         = $App->subject;
                $data["body"]            = $App->body;
                $data["time_paid"]       = $App->time_paid;
                $data["time_expire"]     = $App->time_expire;
                $data["time_settle"]     = $App->time_settle;
                $data["amount_refunded"] = $App->amount_refunded;
                $data["failure_code"]    = $App->failure_code;
                $data["failure_msg"]     = $App->failure_msg;
                $data["description"]     = $App->description;

                break;
            }
        }

        return $data;// 输出 Ping++ 返回 App 对象
    }
}
