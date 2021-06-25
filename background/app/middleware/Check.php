<?php
declare (strict_types=1);

namespace app\middleware;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure $next
     * @return \think\response\Json
     */
    public function handle($request, \Closure $next)
    {
        $header = $request->header();

        //此处用来判断是否是非法请求
//        if (!isset($header['referer']) || !strstr($header['referer'], 'http://my.ycshop.local/')) {
//            return json(['code' => 451, 'msg' => 'invalid request']);
//        }

        return $next($request);
    }
}
