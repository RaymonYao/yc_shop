<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\facade\View;

class Index
{
    /**
     * @throws \Exception
     */
    public function index(): string
    {
        $username = session('username');
        return View::fetch('index', ['user' => $username]);
    }

    public function welcome(): string
    {
        return View::fetch('welcome');
    }
}
