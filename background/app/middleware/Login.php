<?php
declare (strict_types=1);

namespace app\middleware;

use Closure;
use think\Request;

class Login
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure $next
     * @return \think\response\Redirect
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('username')) {
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
