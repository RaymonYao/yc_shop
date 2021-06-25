<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\Request;
use think\facade\View;
use think\facade\Db;

class Goods
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return View::fetch('index');
    }

    public function getGoods(Request $request)
    {
        $limit = $request->param('limit') ? $request->param('limit') : 6;
        $goods = Db::name('goods')
            ->alias('g')
            ->join('cat c', 'g.cat_id=c.id')
            ->field(['g.id', 'g.goods_name', 'g.goods_price', 'g.goods_img', 'g.is_show', 'c.cat_name'])
            ->paginate($limit)
            ->toArray();
        return json(['code' => 0, 'count' => $goods['total'], 'data' => $goods['data']]);

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $cats = Db::name('cat')->select()->toArray();
        $cats = tree($cats);

        return View::fetch('add', ['cats' => $cats]);
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->except(['fileselect']);

        $res = Db::name('goods')->insert($data);
        if ($res) {
            return json(['status' => 'success', 'msg' => '上传成功']);
        } else {
            return json(['status' => 'fail', 'msg' => '上传失败']);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $goods = Db::name('goods')->where('id', $id)->find();
        $cats = Db::name('cat')->select()->toArray();
        $cats = tree($cats);
        return View::fetch('edit', ['goods' => $goods, 'cats' => $cats]);
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['fileselect']);

        $res = Db::name('goods')->where('id', $id)->update($data);

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
     */
    public function delete($id)
    {


        $res = Db::name('goods')->where('id', $id)->delete();
        if ($res) {
            return json(['status' => 'success', 'msg' => '删除成功']);
        } else {
            return json(['status' => 'fail', 'msg' => '删除失败']);
        }
    }

    public function upload(Request $request)
    {

        $file = $request->file('file');
        $savename = \think\facade\Filesystem::putFile('goods', $file, 'md5');

        return json(['status' => 'success', 'img_url' => '/storage/' . $savename]);
    }

    public function uploadGoods(Request $request)
    {

        $file = $request->file('image');
        $savename = \think\facade\Filesystem::putFile('goods', $file, 'md5');

        return json(['code' => 1, 'msg' => '上传成功', 'data' => ['url' => ['/storage/' . $savename]]]);
    }

    public function isShow(Request $request)
    {
        $id = $request->param('id');
        $is_show = $request->param('is_show');
        if ($is_show) {
            Db::name('goods')->where('id', $id)->update(['is_show' => 0]);
        } else {
            Db::name('goods')->where('id', $id)->update(['is_show' => 1]);
        }
    }
}
