<?php
declare (strict_types=1);

namespace app\api\controller;

use think\facade\Db;

class Goods
{

    public function getIndexGoods()
    {
        $goods = Db::name('goods')->where('is_show', 1)->field(['goods_name', 'id', 'goods_img', 'goods_price'])->paginate(6)->toArray();
        if ($goods) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $goods['data']];
        } else {
            $data = ['code' => 440, 'msg' => 'no goods'];
        }

        return json($data);
    }

    public function getCatGoods($id)
    {
        $goods = Db::name('goods')->where('is_show', 1)->where('cat_id', $id)->field(['goods_name', 'id', 'goods_img', 'goods_price'])->select()->toArray();
        if ($goods) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $goods];
        } else {
            $data = ['code' => 440, 'msg' => 'no goods'];
        }
        return json($data);
    }

    public function getGoodsDetail($id)
    {
        $goods = Db::name('goods')->where('id', $id)->find();

        $goods['goods_introduce'] = preg_replace('/(<img.+?src=")(.*?)/', "$1" . config('shop.API_HOST') . "$2", $goods['goods_introduce']);

        if ($goods) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $goods];
        } else {
            $data = ['code' => 440, 'msg' => 'no goods'];
        }
        return json($data);
    }

    public function getGoods($id)
    {
        $goods = Db::name('goods')->where('id', $id)->field(['goods_name', 'goods_img', 'id', 'goods_price'])->find();

        if ($goods) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $goods];
        } else {
            $data = ['code' => 440, 'msg' => 'no goods'];
        }
        return json($data);
    }
}
