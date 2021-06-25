<?php
declare (strict_types=1);

namespace app\api\controller;

use think\Request;
use think\facade\Db;

class Address
{
    public function saveAddr(Request $request)
    {
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile', $ret['mobile'])->value('id');
        $data = $request->param();
        $data['user_id'] = $user_id;

        $res = Db::name('address')->insert($data);

        if ($res) {
            return json(['code' => 200, 'msg' => '新增地址成功']);
        } else {
            return json(['code' => 440, 'msg' => '新增地址失败']);
        }

    }

    public function getAddr(Request $request)
    {
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile', $ret['mobile'])->value('id');
        $addrs = Db::name('address')->where('user_id', $user_id)->select()->toArray();
        if ($addrs) {
            return json(['code' => 200, 'msg' => 'success', 'data' => $addrs]);
        } else {
            return json(['code' => 440, 'msg' => 'fail']);
        }


    }

    public function delAddr($id)
    {
        $res = Db::name('address')->where('id', $id)->delete();
        if ($res) {
            return json(['code' => 200, 'msg' => '删除成功']);
        } else {
            return json(['code' => 440, 'msg' => 'fail']);
        }
    }

    public function getOneAddr(Request $request)
    {
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile', $ret['mobile'])->value('id');
        $addr = Db::name('address')->where('user_id', $user_id)->order('id desc')->find();

        if ($addr) {
            return json(['code' => 200, 'msg' => 'success', 'data' => $addr]);
        } else {
            return json(['code' => 440, 'msg' => 'fail']);
        }


    }

}
