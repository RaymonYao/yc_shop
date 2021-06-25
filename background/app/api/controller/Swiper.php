<?php
declare (strict_types=1);

namespace app\api\controller;

use think\facade\Db;

class Swiper
{
    public function getSwipers()
    {
        $swipers = Db::name('swiper')->where('is_show', 1)->select()->toArray();
        if ($swipers) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $swipers];
        } else {
            $data = ['code' => 440, 'msg' => 'no swiper'];
        }

        return json($data);
    }
}
