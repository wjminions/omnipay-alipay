<?php

namespace Omnipay\Alipay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Alipay\Helper;

class AppPurchaseRequest extends AbstractAppRequest
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

        $data = array (
            "app_id" => $this->getAppId(),
            "rsa_private_key" => $this->getRsaPrivateKey(),
            "environment" => $this->getEnvironment(),
            "sign_type" => $this->getSignType(),
            "alipay_rsa_public_key" => $this->getAlipayRsaPublicKey(),
            "subject" => $this->getSubject(),
            "body" => $this->getBody(),
            "out_trade_no" => $this->getOutTradeNo(),
            "timeout_express" => $this->getTimeoutExpress(),
            "total_amount" => $this->getTotalAmount(),
        );

        return $data;
    }


    private function validateData()
    {
        $this->validate(
            'app_id',
            'rsa_private_key',
            'environment',
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
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        \Pingpp\Pingpp::setApiKey($data['app_key']);                                         // 设置 API Key


        include("AopSdk.php");

        $aop = new AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = "2017061707509543";
        $aop->rsaPrivateKey = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKBglPymZNXoWujtFUbNwsAi3e4nLhzlUtq+lqG0lQJcS5cK5rag4qDFMP5JUIs8TnbguBTOTsAvB0TTiLRAQTdhpoyX4kNKLcJQO4tw4QyqRbW+mJmz27nfBL2gOIGa5QnQ9BDHBxRyXSydSUymDUSAoKok0XaJZDa6TvRV7DcpAgMBAAECgYASCks4EE+PcE+pm+Gk0Uhy7HkibO3W+kTTrlSrY/DPDyrBlsxVBsv3YbcdI4oX33TEEosibAKXw7KBn3nlLMUpEyR0BXrdKt2VCLFDejrxN/SrhkhDEYC6Xbj5c4VC+0lcJ6txYkUH1j+oFEf5e3XCiH4eqNo1Sz72Dz3II/z7wQJBAPe98bXMSVVJuicKvS1sPU9bfX7bXq9IqRX7ean3WeUVfFikQS0FxH59z0CrRnw1p37kHiIZDeIyuqZRPTWDdKUCQQCluSD/S1zL0Y+m9TXDuDKSIhPA7WIgo+CjsaVRAOUEayT6eo6I+Zl1Na6fbZ/PlLs1qfaV7axjQqnXBIsIVv01AkEA4XQ5WKGdhwE+aDNMr96V+PcgwOZwR4IPZlLhiHzykRi5fY2VRpy+EgL6LjbwQS8uy7pbddppGRXjaGH8GwwThQJAacz3NAV5COaRP5Xs7Tb7kjAPTGxA6XW2RMt1L3HSxC9jPEZiGTDAuAO9qCrkjDH4ExqfQriqBfTZWVydJoXiwQJAODQ0+m3J+TjjpFIZbZ7n0XHRGeYaMSL0e1PbwS4cEAr5mUwm5ks5nvmO9UpVEMNGQPbnCoqwZIv6vyAdNuehOw==';
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = '{"body":"i am a test","subject":"App pay","out_trade_no":"20170125test01","timeout_express":"30m","total_amount":"0.01","product_code":"QUICK_MSECURITY_PAY"}';
        $request->setNotifyUrl("127.0.0.6");
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。


        return $this->response = new AppPurchaseResponse($this, (array) json_decode($charge));
    }
}
