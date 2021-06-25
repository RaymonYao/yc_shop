<?php
declare (strict_types=1);

namespace app\api\controller;

use think\facade\Db;

class Express
{
    //

    public function getExp($id)
    {
        $exp = Db::name('express')->where('order_id', $id)->find();
        require_once '../extend/express/Exp.php';

        $params = array(
            'key' => '3a3d030eefba977a90c1f97457ee41c4', //您申请的快递appkey
            'com' => $exp['exp_com'], //快递公司编码，可以通过$exp->getComs()获取支持的公司列表
            'no' => $exp['exp_no'] //快递编号
        );
        $exp = new \Exp($params['key']); //初始化类

        $result = $exp->query($params['com'], $params['no']); //执行查询

        if ($result['error_code'] == 0) {//查询成功
            $list = $result['result']['list'];
            return json(['code' => 200, 'msg' => 'success', 'data' => $list]);
        } else {
            echo "获取失败，原因：" . $result['reason'];
        }

    }


}
