<?php
declare (strict_types=1);

namespace app\api\controller;

use think\Request;

class User
{
    public function getUser(Request $request)
    {
        $token = $request->header()['token'];
        $mobile = $token->getClaim('mobile');
        return json(['code' => 200, 'msg' => 'success', 'mobile' => $mobile]);

    }
}
