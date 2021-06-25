<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\facade\Filesystem;
use think\Request;
use think\response\Json;

class System
{
    /**
     * @param \think\Request $request
     * @return \think\response\Json
     */
    public function upload(Request $request): Json
    {
        $file = $request->file('file');
        $saveName = Filesystem::putFile('swiper', $file, 'md5');
        return json(['status' => 'success', 'img_url' => '/storage/' . $saveName]);
    }
}
