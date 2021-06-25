<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\captcha\facade\Captcha;
use think\facade\View;
use think\Request;
use think\facade\Db;

class Login
{
    public function login(Request $request)
    {
        if ($request->isPost()) {
            $captcha = $request->param('captcha', '', 'trim');
            $username = $request->param('username', '', 'trim');
            $password = $request->param('password', '', 'trim');
            //csrf + 验证码   ip验证  +密码错误次数
            if (!captcha_check($captcha)) {
                return json(['status' => 'fail', 'msg' => '验证码不正确']);
            }

            $user = Db::name('admin')->where('username', $username)->find();

            if (!$user) {
                return json(['status' => 'fail', 'msg' => '用户名不存在']);
            }

            if ($user['password'] != md5($password)) {
                return json(['status' => 'fail', 'msg' => '密码不正确']);
            }

            session('username', $username);
            return json(['status' => 'success', 'msg' => '登录成功']);


        } else {
            return View::fetch('login');
        }

    }

    public function captcha()
    {
        return Captcha::create();
    }

    public function logout()
    {
        session('username', null);
        return json(['status' => 'success', 'msg' => '退出登录成功']);
    }
}
