<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\Request;
use think\facade\Db;

class Comment
{
    public function saveComment(Request $request){
        $token = $request->header()['token'];
        $ret = getMobile($token);
        $user_id = Db::name('user')->where('mobile',$ret['mobile'])->value('id');	
		$goods_id = Db::name('orders')->where('id',$request->param('order_id'))->value('goods_id');

		$data = ['user_id'=>$user_id,'content'=>$request->param('content'),'create_time'=>time(),'goods_id'=>$goods_id];	

		$res = Db::name('comments')->insert($data);

		if($res){
			Db::name('orders')->where('id',$request->param('order_id'))->update(['is_comment'=>1]);
			return json(['code'=>200,'msg'=>'success']);
		}else{

		 return json(['code'=>400,'msg'=>'fail']);}

	}

	public function getComment($id){
		$comments = Db::name('comments')->alias('c')->join('user u','c.user_id=u.id')
										->where('goods_id',$id)
										->field(['u.mobile','c.content','c.create_time'])
										->withAttr('create_time',function($value,$data){
                        					return date('Y-m-d H:i:s',$value);

                 						})->select()->toArray();	

		if($comments){
			return json(['code'=>200,'msg'=>'success','data'=>$comments]);
		}		

	}

}
