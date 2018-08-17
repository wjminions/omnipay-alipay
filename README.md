# Omnipay: Alipay

**Alipay driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/lokielse/omnipay-alipay.png?branch=master)](https://travis-ci.org/lokielse/omnipay-alipay)
[![Latest Stable Version](https://poser.pugx.org/lokielse/omnipay-alipay/version.png)](https://packagist.org/packages/lokielse/omnipay-alipay)
[![Total Downloads](https://poser.pugx.org/lokielse/omnipay-alipay/d/total.png)](https://packagist.org/packages/lokielse/omnipay-alipay)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Alipay support for Omnipay.

> This package only support Alipay service

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "wjminions/omnipay-alipay": "dev-master"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Alipay_Web (Alipay Web Gateway) 支付宝国际版Web支付宝接口
* Alipay_Wap (Alipay Wap Gateway) 支付宝国际版Wap支付宝接口
* Alipay_App (Alipay App Gateway) 支付宝国际版App支付宝接口

## Usage


* Sandbox information: [SANDBOX.md](SANDBOX.md)
* Documentation: [Alipay Guid](https://ds.alipay.com/fd-ij9mtflt/home.html)

### Purchase
```php
/**
 * @var Omnipay\Alipay\WebGateway $gateway
 */
//gateways: Alipay_Web, Alipay_Wap, Alipay_App
$gateway = Omnipay::create('Alipay_Web');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here'); //for sign_type=MD5
$gateway->setPrivateKey($privateKeyPathOrData); //for sign_type=RSA
$gateway->setReturnUrl('http://www.example.com/return');
$gateway->setNotifyUrl('http://www.example.com/notify');
$gateway->setEnvironment('sandbox'); //for Sandbox Test (Web/Wap)

$params = [
    'out_trade_no' => date('YmdHis') . mt_rand(1000,9999), //your site trade no, unique
    'subject'      => 'test', //order title
    'total_fee'    => '0.01', //order total fee
    'currency'     => 'USD', //default is 'USD'
];

/**
 * @var Omnipay\Alipay\Message\WebPurchaseResponse $response
 */
$response = $gateway->purchase($params)->send();

//$response->redirect();
var_dump($response->getRedirectUrl());
var_dump($response->getRedirectData());
var_dump($response->getOrderString()); //for Alipay_App

```

### Return/Notify
```php
/**
 * @var Omnipay\Alipay\WebGateway $gateway
 */
$gateway = Omnipay::create('Alipay_Web');
$gateway->setPartner('8888666622221111');
$gateway->setKey('your**key**here'); //for sign_type=MD5
$gateway->setPrivateKey($privateKeyPathOrData); //for sign_type=RSA
$gateway->setEnvironment('sandbox'); //for Sandbox Test (Web/Wap)

$params = [
    'request_params' => array_merge($_GET, $_POST), //Don't use $_REQUEST for may contain $_COOKIE
];

$response = $gateway->completePurchase($params)->send();

/**
 * @var Omnipay\Alipay\Message\CompletePurchaseResponse $response
 */
if ($response->isPaid()) {

   // Paid success, your statements go here.

   //For notify, response 'success' only please.
   //die('success');
} else {

   //For notify, response 'fail' only please.
   //die('fail');
}
```


For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Related

- [Laravel-Omnipay](https://github.com/ignited/laravel-omnipay)
- [Omnipay-Alipay](https://github.com/lokielse/omnipay-alipay)
- [Omnipay-WechatPay](https://github.com/lokielse/omnipay-wechatpay)
- [Omnipay-UnionPay](https://github.com/lokielse/omnipay-unionpay)

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/lokielse/omnipay-alipay/issues),
or better yet, fork the library and submit a pull request.

