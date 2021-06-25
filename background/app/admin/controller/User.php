<?php
declare (strict_types = 1);

namespace app\admin\controller;
use think\facade\View;
use think\Request;
use think\facade\Db;

class User
{
    
	public function index(){
		return View::fetch('index');
	}

	public function getUser(Request $request){
		 $limit = $request->param('limit')?$request->param('limit'):6;
         $user = Db::name('user')->withAttr('login_time',function($value,$data){
			return date('Y-m-d H:i:s',$value);

		 })->paginate($limit)->toArray();

         return json(['code'=>0, 'count'=>$user['total'], 'data'=>$user['data']]);
		
	}

	 public function isShow(Request $request){
                $id = $request->param('id');
                $is_show = $request->param('is_show');
                if($is_show){
                        Db::name('user')->where('id',$id)->update(['is_frozen'=>0]);
                }else{
                        Db::name('user')->where('id',$id)->update(['is_frozen'=>1]);
                }
        }
	
}
