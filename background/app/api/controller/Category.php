<?php
declare (strict_types=1);

namespace app\api\controller;

use think\facade\Db;

class Category
{
    public function getCats()
    {
        $cats = Db::name('cat')->where('is_show', 1)->where('pid', 0)->select()->toArray();
        if ($cats) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $cats];
        } else {
            $data = ['code' => 440, 'msg' => 'no cats'];
        }

        return json($data);
    }

    public function getSubcats($id)
    {
        if ($id == 'null') {
            $pid = Db::name('cat')->where('is_show', 1)->where('pid', 0)->value('id');
            $cats = Db::name('cat')->where('is_show', 1)->where('pid', $pid)->select()->toArray();
        } else {
            $cats = Db::name('cat')->where('is_show', 1)->where('pid', $id)->select()->toArray();
        }

        if ($cats) {
            $data = ['code' => 200, 'msg' => 'success', 'data' => $cats];
        } else {
            $data = ['code' => 440, 'msg' => 'no cats'];
        }

        return json($data);

    }
}
