<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\facade\Filesystem;
use think\Request;
use think\facade\View;
use think\facade\Db;
use think\Response;
use think\response\Json;

class Swiper
{
    /**
     * 显示资源列表
     *
     * @return string
     */
    public function index(): string
    {
        return View::fetch('index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return string
     */
    public function create(): string
    {
        return View::fetch('add');
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request): Response
    {
        $data = $request->except(['fileselect']);

        $res = Db::name('swiper')->insert($data);
        if ($res) {
            return json(['status' => 'success', 'msg' => '上传成功']);
        } else {
            return json(['status' => 'fail', 'msg' => '上传失败']);
        }

    }

    /**
     * 显示指定的资源
     * @param int $id
     */
    public function read(int $id)
    {

    }

    /**
     * @param int $id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit(int $id): string
    {
        $swiper = Db::name('swiper')->where('id', $id)->find();
        return View::fetch('edit', ['swiper' => $swiper]);
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id): Response
    {
        $data = $request->except(['fileselect']);

        $res = Db::name('swiper')->where('id', $id)->update($data);

        if ($res) {
            return json(['status' => 'success', 'msg' => '更新成功']);
        } else {
            return json(['status' => 'fail', 'msg' => '更新失败']);
        }
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function delete(int $id): Response
    {
        $res = Db::name('swiper')->where('id', $id)->delete();
        if ($res) {
            return json(['status' => 'success', 'msg' => '删除成功']);
        } else {
            return json(['status' => 'fail', 'msg' => '删除失败']);
        }
    }

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

    /**
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function getSwiperList(Request $request): Json
    {
        $sWipers = Db::name('swiper')->paginate($request->get('limit', 10))->toArray();
        return json(['code' => 0, 'count' => $sWipers['total'], 'data' => $sWipers['data']]);
    }

    /**
     * @param \think\Request $request
     * @throws \think\db\exception\DbException
     */
    public function isShow(Request $request)
    {
        $id = $request->param('id');
        $is_show = $request->param('is_show');
        if ($is_show) {
            Db::name('swiper')->where('id', $id)->update(['is_show' => 0]);
        } else {
            Db::name('swiper')->where('id', $id)->update(['is_show' => 1]);
        }
    }
}
