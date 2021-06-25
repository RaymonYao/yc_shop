<?php
declare (strict_types=1);

namespace app\api\controller;

use think\Request;
use think\facade\Db;

class Pay
{
    //

    public function pay(Request $request)
    {
        $data = $request->param();

        $ids = json_decode($data['orderId'], true);
        $total = 0;
        foreach ($ids as $id) {
            $order = Db::name('orders')->where('id', $id)->field(['order_no', 'total'])->find();
            $total = $total + $order['total'];

        }

        if ($data['type'] == 'zfb') {

            $payInfo['total'] = $total;
            $payInfo['out_trade_no'] = $order['order_no'];

            //处理完数据  调用支付宝支付
            return $this->aliPay($payInfo);
        } else {
            $payParam['outTradeNo'] = $order['order_no'];
            $payParam['payAmount'] = $total;
            $payParam['orderName'] = $order['order_no'];
            $payParam['wapName'] = 'H5';
            $payParam['ip'] = $request->ip();

            $url = $this->wxPay($payParam);
            return '<form action=' . $url . ' method="post" name="alipaysubmit"></form>';
        }

    }

    public function wxPay($data)
    {

        require_once '../extend/wxpay/wxPay.php';
        $config = config('pay.WXPAY');
        $wxPay = new \wxPay($config, $data);
        $url = $wxPay->createBizPackage();
        return $url;
    }


    public function wxCallback()
    {
        require_once '../extend/wxpay/Sign.php';

        $key = config('pay.WXPAY.key');;

        $data = file_get_contents('php://input');

        $xmlObj = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        $arr = json_decode(json_encode($xmlObj), true);


        $res = \Sign::verifySign($arr, $key);

        if ($res) {
            //file_put_contents('data.txt',json_encode($xmlObj));
            //file_put_contents('res.txt','success');
            if ($arr['result_code'] == 'SUCCESS' && $arr['return_code'] == 'SUCCESS') {
                $total = Db::name('orders')->where('order_no', $arr['out_trade_no'])->sum('total');

                if ($total == ($arr['total_fee'] / 100)) {
                    Db::name('orders')->where('order_no', $arr['out_trade_no'])
                        ->update(['is_pay' => 1, 'trade_no' => $arr['transaction_id']]);

                    return 'success';
                }

            }


        } else {
            file_put_contents('res.txt', 'fail');
        }

    }

    public function aliPay($data)
    {
        header("Content-type: text/html; charset=utf-8");
        require_once '../extend/alipay/wappay/service/AlipayTradeService.php';
        require_once '../extend/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
        require '../extend/alipay/config.php';

        $out_trade_no = $data['out_trade_no'];

        //订单名称，必填
        $subject = $data['out_trade_no'];

        //付款金额，必填
        $total_amount = $data['total'];

        //商品描述，可空
        //$body = $_POST['WIDbody'];

        //超时时间
        $timeout_express = "1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        // $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService($config);
        $result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $config['notify_url']);

        return $result;
    }

    public function aliCallback(Request $request)
    {
        require_once '../extend/alipay/config.php';
        require_once '../extend/alipay/wappay/service/AlipayTradeService.php';


        $arr = $request->param();
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);

        if ($result) {
            if ($arr['trade_status'] == 'TRADE_SUCCESS') {
                $total = Db::name('orders')->where('order_no', $arr['out_trade_no'])->sum('total');

                if ($total == $arr['total_amount']) {
                    Db::name('orders')->where('order_no', $arr['out_trade_no'])
                        ->update(['is_pay' => 1, 'trade_no' => $arr['trade_no']]);

                    return 'success';
                }

            }

        } else {
            return 'fail';
        }

    }

}
