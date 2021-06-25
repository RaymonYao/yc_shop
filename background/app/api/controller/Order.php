<?php
declare (strict_types=1);

namespace app\api\controller;

use think\Request;
use think\facade\Db;

class Order
{
    //


    public function getOrder(Request $request, $order_type)
    {
        $orders = $request->param();
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile', $ret['mobile'])->value('id');

        if ($order_type == 'allOrder') {
            $orders = Db::name('orders')->alias('o')->join('goods g', 'o.goods_id=g.id')
                ->where('user_id', $user_id)
                ->order('o.id desc')
                ->field(['g.goods_name', 'g.goods_img', 'o.total', 'o.is_pay', 'o.is_exp', 'o.is_rec', 'o.is_comment', 'o.id'])
                ->select()->toArray();

        } elseif ($order_type == 'waitPay') {

            $orders = Db::name('orders')->alias('o')->join('goods g', 'o.goods_id=g.id')
                ->where('user_id', $user_id)
                ->where('is_pay', 0)
                ->order('o.id desc')
                ->field(['g.goods_name', 'g.goods_img', 'o.total', 'o.is_pay', 'o.is_exp', 'o.is_rec', 'is_comment', 'o.id'])
                ->select()->toArray();

        } elseif ($order_type == 'waitRec') {
            $orders = Db::name('orders')->alias('o')->join('goods g', 'o.goods_id=g.id')
                ->where('user_id', $user_id)
                ->where('is_pay', 1)
                ->order('o.id desc')
                ->field(['g.goods_name', 'g.goods_img', 'o.total', 'o.is_pay', 'o.is_exp', 'o.is_rec', 'is_comment', 'o.id'])
                ->select()->toArray();

        }

        return json(['code' => 200, 'status' => 'success', 'data' => $orders]);
    }

    public function receive($id)
    {

        $res = Db::name('orders')->where('id', $id)->update(['is_rec' => 1]);

        if ($res) {
            return json(['code' => 200, 'msg' => 'success']);
        } else {
            return json(['code' => 400, 'msg' => 'fail']);
        }
    }


    public function saveOrder(Request $request)
    {
        $orders = $request->param();
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile', $ret['mobile'])->value('id');

        $addr_id = Db::name('address')->where('user_id', $user_id)->order('id desc')->limit(1)->value('id');
        if (!$addr_id) {
            return json(['code' => 460, 'msg' => '添加收货地址']);
        }
        $order_no = $this->getOrderNo();
        foreach ($orders as $order) {
            $order['order_no'] = $order_no;
            $order['user_id'] = $user_id;
            $order['create_time'] = time();
            $order['addr_id'] = $addr_id;
            $order['total'] = $order['goods_price'] * $order['num'];
            $id = Db::name('orders')->insertGetId($order);
            $ids[] = $id;

        }
        return json(['code' => 200, 'msg' => 'success', 'data' => $ids]);

    }


    public function getOrderNo()
    {
        return time() . rand(100, 999);
    }
}
