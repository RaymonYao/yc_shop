<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\facade\Db;
use think\Request;
use think\facade\View;

class Order
{
    
	public function index(){
		return View::fetch('index');		
	}

	public function exp($id){
		return View::fetch('edit',['id'=>$id]);

	}

	 public function saveExp(Request $request){
		$data = $request->param();
		
		$res = Db::name('express')->insert($data);
		
		if($res){
			Db::name('orders')->where('id',$data['order_id'])->update(['is_exp'=>1]);
			return json(['status'=>'success','msg'=>'成功']); 
		}else{

		 return json(['status'=>'fail','msg'=>'失败']);}
		
	 }

	 public function getOrder(Request $request){
         $limit = $request->param('limit')?$request->param('limit'):6;
         $orders = Db::name('orders')->alias('o')->join('goods g','o.goods_id=g.id')->field(['g.goods_name','g.goods_img','o.total','o.is_pay','is_exp','o.create_time','o.num','o.id'])->order('o.id desc')->withAttr('create_time',function($value,$data){
                        return date('Y-m-d H:i:s',$value);

                 })->paginate($limit)->toArray();

         return json(['code'=>0, 'count'=>$orders['total'], 'data'=>$orders['data']]);

     }

}
